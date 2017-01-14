<?php
/**
 * Class for display sourcecode.
 *
 * @author    Mikael Roos, me@mikaelroos.se
 * @copyright Mikael Roos 2010 - 2015
 * @link      https://github.com/mosbth/csource
 */
namespace Mos\Source;

class CSource
{

    /**
   * Properties
   */
    private $options = [];

    /**
   * Constructor
   *
   * @param array $options to alter the default behaviour.
   *
   * @SuppressWarnings(PHPMD.CyclomaticComplexity)
   * @SuppressWarnings(PHPMD.NPathComplexity)
   */
    public function __construct($options = [])
    {
        $default = [
            'image_extensions' => ['png', 'jpg', 'jpeg', 'gif', 'ico'],
            'spaces_to_replace_tab' => '  ',
            'ignore' => ['.', '..', '.git', '.svn', '.netrc', '.ssh'],
            'add_ignore' => null, // add array with additional filenames to ignore
            'secure_dir' => '.',  // Only display files below this directory
            'base_dir'   => '.',  // Which directory to start look in, defaults to current working directory of the actual script.
            'query_dir'  => isset($_GET['dir'])  ? strip_tags(trim($_GET['dir']))   : null, // Selected directory as ?dir=xxx
            'query_file' => isset($_GET['file']) ? strip_tags(trim($_GET['file']))  : null, // Selected directory as ?dir=xxx
            'query_path' => isset($_GET['path']) ? strip_tags(trim($_GET['path']))  : null, // Selected directory as ?dir=xxx
        ];

        // Add more files to ignore
        if (isset($options['add_ignore'])) {
            $default['ignore'] = array_merge($default['ignore'], $options['add_ignore']);
        }

        $this->options = $options = array_merge($default, $options);

        //Backwards compatible with source.php query arguments for ?dir=xxx&file=xxx
        if (!isset($this->options['query_path'])) {
            $this->options['query_path'] = trim($this->options['query_dir'] . '/' . $this->options['query_file'], '/');
        }

        $this->validImageExtensions = $options['image_extensions'];
        $this->spaces         = $options['spaces_to_replace_tab'];
        $this->ignore         = $options['ignore'];
        $this->secureDir      = realpath($options['secure_dir']);
        $this->baseDir        = realpath($options['base_dir']);
        $this->queryPath      = $options['query_path'];
        $this->suggestedPath  = $this->baseDir . '/' . $this->queryPath;
        $this->realPath       = realpath($this->suggestedPath);
        $this->pathinfo       = pathinfo($this->realPath);
        $this->path           = null;

        // Ensure that extension is always set
        if (!isset($this->pathinfo['extension'])) {
            $this->pathinfo['extension'] = null;
        }

        if (is_dir($this->realPath)) {
            $this->file = null;
            $this->extension = null;
            $this->dir  = $this->realPath;
            $this->path = trim($this->queryPath, '/');
        } else if (is_link($this->suggestedPath)) {
            $this->pathinfo = pathinfo($this->suggestedPath);
            $this->file = $this->pathinfo['basename'];
            $this->extension = strtolower($this->pathinfo['extension']);
            $this->dir  = $this->pathinfo['dirname'];
            $this->path = trim(dirname($this->queryPath), '/');
        } else if (is_readable($this->realPath)) {
            $this->file = basename($this->realPath);
            $this->extension = strtolower($this->pathinfo['extension']);
            $this->dir  = dirname($this->realPath);
            $this->path = trim(dirname($this->queryPath), '/');
        } else {
            $this->file = null;
            $this->extension = null;
            $this->dir  = null;
        }

        if ($this->path == '.') {
            $this->path = null;
        }

        $this->breadcrumb = empty($this->path) ? [] : explode('/', $this->path);

        // Check that dir lies below securedir
        $this->message = null;
        $msg = "<p><i>WARNING: The path you have selected is not a valid path or restricted due to security constraints.</i></p>";
        if (substr_compare($this->secureDir, $this->dir, 0, strlen($this->secureDir))) {
            $this->file = null;
            $this->extension = null;
            $this->dir  = null;
            $this->message = $msg;
        }

        // Check that all parts of the path is valid items
        foreach ($this->breadcrumb as $val) {
            if (in_array($val, $this->ignore)) {
                $this->file = null;
                $this->extension = null;
                $this->dir  = null;
                $this->message = $msg;
                break;
            }
        }

    }



    /**
   * List the sourcecode.
   */
    public function view()
    {
        return $this->getBreadcrumbFromPath()
        . $this->message . $this->readCurrentDir() . $this->getFileContent();
    }



    /**
   * Create a breadcrumb of the current dir and path.
   */
    public function getBreadcrumbFromPath()
    {

        $html  = "<ul class='src-breadcrumb'>\n";
        $html .= "<li><a href='?'>" . basename($this->baseDir) . "</a>/</li>";
        $path = null;
        foreach ($this->breadcrumb as $val) {
            $path .= "$val/";
            $html .= "<li><a href='?path={$path}'>{$val}</a>/</li>";
        }
        $html .= "</ul>\n";

        return $html;
    }



    /**
   * Read all files of the current directory.
   */
    public function readCurrentDir()
    {

        if (!$this->dir) {
            return;
        }

        $html = "<ul class='src-filelist'>";
        foreach (glob($this->dir . '/{*,.?*}', GLOB_MARK | GLOB_BRACE) as $val) {

            if (in_array(basename($val), $this->ignore)) {
                continue;
            }

            $file = basename($val) . (is_dir($val) ? '/' : null);
            $path = (empty($this->path) ? null : $this->path . '/') . $file;
            $html .= "<li><a href='?path={$path}'>{$file}</a></li>\n";
        }
        $html .= "</ul>\n";

        return $html;
    }



    /**
   * Get the details such as encoding and line endings from the file.
   */
    public function detectFileDetails()
    {

        $this->encoding = null;

        // Detect character encoding
        if (function_exists('mb_detect_encoding')) {
            if ($res = mb_detect_encoding($this->content, "auto, ISO-8859-1", true)) {
                $this->encoding = $res;
            }
        }

        // Is it BOM?
        if (substr($this->content, 0, 3) == chr(0xEF) . chr(0xBB) . chr(0xBF)) {
            $this->encoding .= " BOM";
        }

        // Checking style of line-endings
        $this->lineendings = null;
        if (isset($this->encoding)) {
            $lines = explode("\n", $this->content);
            $len = strlen($lines[0]);

            if (substr($lines[0], $len-1, 1) == "\r") {
                $this->lineendings = " Windows (CRLF) ";
            } else {
                $this->lineendings = " Unix (LF) ";
            }
        }

    }



    /**
   * Remove passwords from known files from all files starting with config*.
   */
    public function filterPasswords()
    {

        $pattern = [
            '/(\'|")(DB_PASSWORD|DB_USER)(.+)/',
            '/\$(password|passwd|pwd|pw|user|username)(\s*=\s*)(\'|")(.+)/i',
            //'/(\'|")(password|passwd|pwd|pw)(\'|")\s*=>\s*(.+)/i',
            '/(\'|")(password|passwd|pwd|pw|user|username)(\'|")(\s*=>\s*)(\'|")(.+)([\'|"].*)/i',
            '/(\[[\'|"])(password|passwd|pwd|pw|user|username)([\'|"]\])(\s*=\s*)(\'|")(.+)([\'|"].*)/i',
        ];


        $message = "Intentionally removed by CSource";
        $replace = [
            '\1\2\1,  "' . $message . '");',
            '$\1\2\3' . $message . '\3;',
            '\1\2\3\4\5' . $message . '\7',
            '\1\2\3\4\5' . $message . '\7',
        ];

        $this->content = preg_replace($pattern, $replace, $this->content);
    }



    /**
     * Get the content of the file and format it.
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function getFileContent()
    {

        if (!isset($this->file)) {
            return;
        }

        $this->content = file_get_contents($this->realPath);
        $this->detectFileDetails();
        $this->filterPasswords();

        // Display svg-image or enable link to display svg-image.
        $linkToDisplaySvg = "";
        if ($this->extension == 'svg') {
            if (isset($_GET['displaysvg'])) {
                header("Content-type: image/svg+xml");
                echo $this->content;
                exit;
            } else {
                $linkToDisplaySvg = "<a href='{$_SERVER['REQUEST_URI']}&displaysvg'>Display as SVG</a>";
            }
        }

        // Display image if a valid image file
        if (in_array($this->extension, $this->validImageExtensions)) {

            $baseDir = !empty($this->options['base_dir'])
            ? rtrim($this->options['base_dir'], '/') . '/'
            : null;
            $this->content = "<div style='overflow:auto;'><img src='{$baseDir}{$this->path}/{$this->file}' alt='[image not found]'></div>";
        } else {
            // Display file content and format for a syntax
            $this->content = str_replace('\t', $this->spaces, $this->content);
            $this->content = highlight_string($this->content, true);
            $i=0;
            $rownums = "";
            $text = "";
            $content = explode('<br />', $this->content);

            foreach ($content as $row) {
                $i++;
                $rownums .= "<code><a id='L{$i}' href='#L{$i}'>{$i}</a></code><br />";
                $text .= $row . '<br />';
            }

            $this->content = <<< EOD
<div class='src-container'>
<div class='src-header'><code>{$i} lines {$this->encoding} {$this->lineendings} {$linkToDisplaySvg}</code></div>
<div class='src-rows'>{$rownums}</div>
<div class='src-code'>{$text}</div>
</div>
EOD;
        }

        return "<h3 id='file'><code><a href='#file'>{$this->file}</a></code></h3>{$this->content}";
    }
}
