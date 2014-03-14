<?php
namespace qtil {
    trait Proxy {
        /**
         * Checks if object is currently proxied
         * @return boolean
         */
        function hasSubject() {
            $subject = Proxy\Registry::getSubject($this);
            return empty($subject) ? false : true;
        }

        /**
         * sets object to pipe all magic 
         * @param object $subject
         * @return object
         */
        function setSubject($subject) {
            Proxy\Registry::setSubject($this, $subject);
            return $subject;
        }

        /**
         * Retrieves proxy subject
         * @return mixed
         */
        function getSubject() {
            return Proxy\Registry::getSubject($this);
        }

        /**
         * Checks if proxy subject is an object
         * @return boolean
         */
        private function valid() {
            $subject = Proxy\Registry::getSubject($this);
            return is_object($subject) ? true : false;
        }

        /**
         * delegates __get magic to proxy
         * @param string $name
         * @return mixed
         */
        function __get($name) {
            $subject = Proxy\Registry::getSubject($this);
            return $subject->$name;
        }

        /**
         * delegates __set magic to proxy
         * @param string $name
         * @param mixed $value
         */
        function __set($name,$value) {
            $subject = Proxy\Registry::getSubject($this);
            $subject->$name = $value;
        }
        
        /**
         * delegates __unset magic to proxy
         * @param string $name
         */
        function __unset($name) {
            $subject = Proxy\Registry::getSubject($this);
            unset($subject->$name);
        }
        
        /**
         * delegates __isset magic to name
         * @param string $name
         */
        function __isset($name) {
            $subject = Proxy\Registry::getSubject($this);
            return isset($subject->$name);
        }

        /**
         * delegates __call magic to proxy
         * @param string $method
         * @param array $arguments
         * @return mixed
         */
        function __call($method,array $arguments = []) {
            $subject = Proxy\Registry::getSubject($this);
            return call_user_func_array([$subject,$method],$arguments);
        }
    }
}