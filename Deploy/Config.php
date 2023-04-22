<?php

class Config
{
    // Sending VM credentials
    public $sourceHost;
    public $sourceUser;
    public $sourcePass;
    // Folder to zip and send
    public $sourceDir = "/home/audionook/test/";

    // Local Folder to store on Deployment Server
    public $localDir = __DIR__ . "/builds/";

    // Recieving VM credentials
    public $destHost;
    public $destUser;
    public $destPass;
    // Folder to unzip the file
    public $destDir = "/home/audionook/test/";

    public function __construct()
    {
        try {
            $dotenv = @parse_ini_file(__DIR__ . "/.env.deploy");
            $this->sourceHost = $dotenv["SOURCE_HOST"];
            $this->sourceUser = $dotenv["SOURCE_USER"];
            $this->sourcePass = $dotenv["SOURCE_PASS"];

            $this->destHost = $dotenv["DEST_HOST"];
            $this->destUser = $dotenv["DEST_USER"];
            $this->destPass = $dotenv["DEST_PASS"];
        } catch (Exception $e) {
            error_log("Error loading .env file: " . $e->getMessage());
        }
    }
}
