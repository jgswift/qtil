<?php
namespace qtil {
    trait Factory {
        use Reflector;

        /**
         * Locally scoped alias of build
         * @param string $className
         * @param array $arguments
         * @param boolean $autoload
         */
        public function make($className, array $arguments = [], $autoload = true) {
            return self::build($className,$arguments,$autoload);
        }
        
        /**
         * Instantiates factory object with given arguments
         * @param string $className
         * @param array $arguments
         * @return mixed
         * @throws \qtil\Exception
         * @throws Exception\
         */
        static function build($className, array $arguments = [], $autoload=true) {    
            if(!is_string($className)) {
                return;
            }

            try {
                if(class_exists($className,$autoload)) {
                    if(($class = self::reflect($className)) !== false) {
                        if($class->isInstantiable() && !$class->isAbstract()) {
                            $cons = $class->getConstructor();

                            if($cons instanceof \ReflectionMethod) {
                                $params = $cons->getParameters();

                                foreach($params as $param) {
                                    if(!array_key_exists($param->getPosition(), $arguments)) {
                                        if($param->isDefaultValueAvailable()) {
                                            $arguments[$param->getPosition()] = $param->getDefaultValue();
                                        } elseif($param->allowsNull()) {
                                            $arguments[$param->getPosition()] = null;
                                        }
                                    }
                                }
                            }

                            $object = $class->newInstanceArgs($arguments);

                            return $object;
                        } else {
                            throw new Exception('Cannot instantiate class("'.$className.'")');
                        }
                    }
                }
            } catch(\Exception $e) {
                throw $e;
            }
        }
    }
}