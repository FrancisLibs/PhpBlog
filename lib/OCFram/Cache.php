<?php
namespace OCFram;

class Cache extends ApplicationComponent
{
    protected $folder;
    protected $expirationTime;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->folder = __DIR__.'/../../tmp/cache/views/';
    }

    public function defineFileName($appName, $module, $view)
    {
        $this->fileName = $this->folder . $appName . '_' . $module . '_' . $view;
    }

    public function openFile($fileName)
    {
        $handle = fopen($fileName, "r");

        return $handle;
    }

    public function read($fileName)
    {
        $data = unserialize(file_get_contents());

        return $data;
    }

    public function readExpirationTime()
    {
        $handle = fopen($this->fileName, "r");
        fseek($handle, 0);
        if($handle)
        {
            $time = fgets($handle);
        }

        return $time;
    }

    public function writeExpirationTime()
    {
        $handle = fopen($this->fileName, "w+");
        if($handle)
        {
            $time = $this->defineExpirationTime();
            fwite($handle,$time);
        }
    }

    public function fileExist($fileName)
    {
        return file_exists($fileName);
    }

    public function fileIsExpired($fileName)
    {
        // Lecture de la 1ère ligne du fichier
        $handle = fopen($fileName, "r");
        if($handle)
        {
            $ligne =fgets($handle);
        }
    }

    public function defineExpirationTime()
    {
        $expirationTime = new \DateTime();
        $expirationTime->add(new \DateInterval('PT10S'));
    }
}
