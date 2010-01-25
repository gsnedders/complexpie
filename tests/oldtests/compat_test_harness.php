<?php

class Unit_Test2
{
    public $test = true;
    public $name;
    public $expected;
    public $result;
    protected $data;

    /**
     * Set the test name to the class name by default, replacing "_" with " "
     */
    public function Unit_Test2()
    {
        $this->name = str_replace('_', ' ', get_class($this));
    }

    /**
     * Whether this class is a test
     */
    function is_test()
    {
        return (bool) $this->test;
    }

    /**
     * Test name
     */
    function name()
    {
        return $this->name;
    }
    
    public function run()
    {
        $this->init();
        $this->data();
        $this->expected();
        $this->test();
    }
    
    protected function init() {}
    protected function data() {}
    protected function expected() {}
    protected function test() {}
}

class Unit_Test2_Group
{
    public $name;
    public $tests;
    
    public function Unit_Test2_Group($name)
    {
        $this->name = $name;
    }

    /**
     * Add a test (a Unit_Test2 child, or a Unit_Test2_Group)
     *
     * @access public
     * @param object $test Test to add
     */
    function add($test)
    {
        $this->tests[$test->name][] = $test;
    }

    /**
     * Remove a test
     *
     * @access public
     * @param string $name Test name
     */
    function remove($name)
    {
        unset($this->tests[$name]);
    }

    /**
     * Load tests in folder
     *
     * This loads all the Unit_Test2 classes within files with the same
     * extension as this file within the specified folder
     *
     * @access public
     * @param string $folder Folder name
     */
    function load_folder($folder)
    {
        static $extension = null;
        if (!$extension)
        {
            $extension = pathinfo(__FILE__, PATHINFO_EXTENSION);
        }
        $files = Unit_Test2_Files::get_files($folder);
        $count_classes = count(get_declared_classes());
        foreach ($files as $file)
        {
            if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === $extension)
            {
                include $file;
            }
        }
        $classes = array_slice(get_declared_classes(), $count_classes);
        foreach ($classes as $class)
        {
            if (is_subclass_of($class, 'Unit_Test2'))
            {
                $class = new $class;
                if ($class->is_test())
                {
                    $this->add($class);
                }
            }
        }
    }
}

/**
 * File listing class
 *
 * @package Unit Test
 */
class Unit_Test2_Files
{
    /**
     * Get a list of files/folders within $dir
     *
     * @static
     * @access public
     * @param string $dir Folder to get listing for
     * @return array
     */
    function get_files($dir)
    {
        $files = array();
        if ($dh = opendir($dir))
        {
            while (($file = readdir($dh)) !== false)
            {
                if (substr($file, 0, 1) != '.')
                {
                    $files[] = "$dir/$file";
                }
            }
            closedir($dh);
            usort($files, array(__CLASS__, 'sort_files'));
            foreach ($files as $file)
            {
                if (is_dir($file))
                {
                    array_splice($files, array_search($file, $files), 0, Unit_Test2_Files::get_files($file));
                }
            }
        }
        return $files;
    }

    /**
     * Sort files/folders with files listed before inner folders
     *
     * @static
     * @access public
     * @param string $a File/folder 1
     * @param string $b File/folder 2
     * @return int
     */
    function sort_files($a, $b)
    {
        if (is_dir($a) && is_dir($b))
        {
            return strnatcmp($a, $b);
        }
        else if (is_dir($a))
        {
            return 1;
        }
        else if (is_dir($b))
        {
            return -1;
        }
        else
        {
            return strnatcmp($a, $b);
        }
    }
}