<?php
namespace qtil\Factory {
    class ClassNotFoundException extends \Exception {
        public function __construct($class, $code = -1, $previous = null) {
            parent::__construct('Class not found "'.$class.'"', $code, $previous);
        }
    }
}