<?php
namespace qtil {
    class JSONUtil {
        /**
         * Alias for json_encode
         * @param mixed $input
         * @param integer $options
         * @param integer $depth
         * @return string
         */
        public static function encode($input, $options = 0, $depth=512) {
            return json_encode($input, $options, $depth);
        }

        /**
         * Alias for json_decode with error handling
         * @param mixed $input
         * @param boolean $assoc
         * @param integer $depth
         * @param integer $options
         * @return mixed
         * @throws Exception
         */
        public static function decode($input, $assoc = false, $depth = 512, $options = 0) {
            $out = json_decode($input, $assoc, $depth, $options);

            $error = json_last_error();
            if(empty($error)) {
                return $out;
            }

            throw new Exception('Decoding input failed ("'.$error.'") raw input ("'.$input.'")');
        }
    }
}