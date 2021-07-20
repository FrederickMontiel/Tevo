<?php
    class SystemApi{
        public function randomText($lenght){
            $characters = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTWXYZ";
            $txt = "";

            for ($i = 0; $i < $lenght; $i++){
                $txt .= $characters[rand(0, strlen($characters)-1)];
            }

            return $txt;
        }
    }