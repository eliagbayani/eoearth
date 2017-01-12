<?php
// namespace php_active_record;

class eoearth_controller
{
    function __construct($params)
    {
        $this->download_options = array('download_timeout_seconds' => 4800, 'download_wait_time' => 300000, 'expire_seconds' => false);

        $this->mediawiki_api = "http://" . DOMAIN_SERVER . "/" . MEDIAWIKI_MAIN_FOLDER . "/api.php";

        $elimit = 10;
        $this->api_call = $this->mediawiki_api . "?action=query&list=logevents&letype=upload&lelimit=" . $elimit . "&format=json&rawcontinue";
                                               // ?action=query&list=logevents&letype=upload&lelimit=1                    &rawcontinue&lecontinue=20170105143921|27995

        // $this->exact_path = "http://editors.eol.org/eoearth/wiki/Special:Filepath/Pressure_altitude.jpg";
        $this->exact_path = "http://" . DOMAIN_SERVER . "/" . MEDIAWIKI_MAIN_FOLDER . "/wiki/Special:Filepath/";
        
    }

    function backup_uploads_today()
    {
        self::check_backup_folder(BACKUP_FOLDER);
        
        $today = date('Y-m-d'); //e.g. 2016-07-13
        echo "\nToday: $today\n";

        $yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today))); //e.g. 2016-07-12
        echo "\n$yesterday\n";

        // exit;
        
        
        $range = self::get_range($today);
        print_r($range);

        /* used in initial backup last Jan 12, 2017
        $range = self::get_range("2016-10-17", "2016-10-25");
        $range = self::get_range("2016-11-01", "2016-11-30");
        $range = self::get_range("2016-12-01", "2016-12-30");
        $range = self::get_range("2017-01-01", "2017-01-31");
        */
        
        $url = $this->api_call . "&lestart=$range[lestart]&leend=$range[leend]&ledir=newer";
        // echo "\n" . $url . "\n";
        $json = Functions::lookup_with_cache($url, $this->download_options);
        $arr = json_decode($json, true);
        
        if($recs = $arr['query']['logevents'])
        {
            $path = BACKUP_FOLDER.$today;               //normal operation
            $path = BACKUP_FOLDER.$range["lestart"];    //only when backing up manual range
            
            self::check_backup_folder($path);
            foreach($recs as $rec)
            {
                echo "\n".$rec['title']." -- ".$rec['timestamp'];
                $filename = str_replace("File:", "", $rec['title']);
                $remote_image_path = $this->exact_path . str_replace(" ", "_", $filename);
                $saved_file = "$path/$filename";
                // echo "\n" . $remote_image_path;

                /*
                $file_contents = Functions::get_remote_file($remote_image_path, $this->download_options);
                if($FILE = Functions::file_open($saved_file, 'w')) // normal
                {
                    fwrite($FILE, $file_contents);
                    fclose($FILE);
                }
                */

                $imageString = file_get_contents($remote_image_path);
                if($save = file_put_contents($saved_file, $imageString)) echo "\nSaved OK [$save][$saved_file]";
                
                sleep(5);
            }
        }
    }
    
    private function backup_now()
    {
        
    }
    
    private function get_range($start, $end = null)
    {
        if(!$end) $end = $start;
        return array("lestart" => $start."T00:00:00Z", "leend" => $end."T23:59:59Z");
    }
    
    private function check_backup_folder($folder)
    {
        if(!file_exists($folder))
        {
            mkdir($folder);
            echo "\nbackup folder created OK\n";
        }
        else echo "\nbackup folder already created...\n";
    }
}
?>
