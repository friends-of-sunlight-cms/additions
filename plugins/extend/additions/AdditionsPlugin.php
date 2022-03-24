<?php

namespace SunlightExtend\Additions;

use Sunlight\GenericTemplates;
use Sunlight\Message;
use Sunlight\Plugin\ExtendPlugin;
use Sunlight\Router;
use Sunlight\Util\Filesystem;

class AdditionsPlugin extends ExtendPlugin
{

    /**
     * Adds removed HCM filelist
     *
     * definition: [hcm]fosc/filelist, string $path, bool $showFileSize[/hcm]
     * use: [hcm]fosc/filelist,"upload/myfiles",true[/hcm]
     *
     * @param array $args
     */
    public function onHcmFileList(array $args)
    {
        $result = "";

        $path = SL_ROOT . ($args['args'][0] ?? "upload");
        $showFileSize = filter_var(($args['args'][1] ?? false), FILTER_VALIDATE_BOOLEAN);

        if (mb_substr($path, -1, 1) != "/") {
            $path .= "/";
        }

        // files MUST be in /upload/...
        if (strncmp($path, $allowed = SL_ROOT . 'upload', strlen($allowed)) !== 0) {
            $args['output'] = Message::error(_lang('additions.hcm.filelist.error'), true);
            return;
        }

        if (@is_dir($path)) {
            $items = [];
            $handle = @opendir($path);
            while (false !== ($item = @readdir($handle))) {
                if (
                    is_dir($path . $item)
                    || $item == "."
                    || $item == ".."
                    || $item[0] == "." // skip files starting with a dot
                    || !Filesystem::isSafeFile($item) // the file is not secure
                ) {
                    continue;
                }
                $items[] = $item;
            }
            natsort($items);

            $result = "<ul class='filelist'>\n";
            foreach ($items as $item) {
                $fullpath = $path . $item;
                $result .= "<li>";
                $result .= "<a href='" . _e(Router::path($fullpath)) . "' target='_blank'>" . $item . "</a>";
                if ($showFileSize) {
                    $result .= " (" . GenericTemplates::renderFilesize(@filesize($fullpath)) . ")";
                }
                $result .= "</li>\n";
            }
            $result .= "</ul>\n";
            @closedir($handle);
        }

        $args['output'] = $result;
    }
}
