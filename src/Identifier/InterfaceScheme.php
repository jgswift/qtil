<?php
namespace qtil\Identifier {
    class InterfaceScheme extends Scheme {
        function applies($object) {
            if(!empty($this->options)) {
                foreach($this->options as $interface) {
                    if($object instanceof $interface) {
                        return true;
                    }
                }
            }
            
            return false;
        }
    }
}
