<?php
//set the namespace
namespace BytesPhp\IO\Compression;

//import internal namespace(s) required
use BytesPhp\IO\FileInfo as FileInfo;

//the 'ZIP' extension class for 'FileInfo'
class FileInfoZIPExtension{

    public static function ZIP(FileInfo $file, array $args): bool {

        //parse the argument(s)
        $archiveFile = null;
        $append = false;
        $relativePath = null;

        $counter = -1;

        foreach($args as $arg) {
            $counter++;

            switch(true) {

                case $counter == 0:
                    $archiveFile = new FileInfo($args[0]);
                    break;

                case $counter == 1:
                    $append = $args[1];
                    break;

                default:
                    break;

            }

        }

        if(is_null($archiveFile)) { //no archive path was set

            throw new \Exception("The first argument has to be the archive file path");
            return false;

        }

        //check for (and create) the parent folder
        if(!$archiveFile->parent->exists){

            $archiveFile->parent->Create();

        }

        //create the archive
        $archive = new \ZipArchive();

        if($append) { //add the file to an existing archive

            if ($archive->open($archiveFile->path) === TRUE) {

                $archive->addFile($file->path, $file->name);
                $archive->close();

                return true;

            } else {

                throw new \Exception("Failed to open archive file at '".$archiveFile->path."'");

                return false;

            }

        } else { //create a new archive

            if ($archive->open($archiveFile->path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {

                $archive->addFile($file->path, $file->name);
                $archive->close();

                return true;

            } else {

                throw new \Exception("Failed to create archive file at '".$archiveFile->path."'");

                return false;

            }

        }

    }

}

?>