<?php
namespace qtil\Identifier {
    class NamespaceScheme extends Scheme {
        function applies($object) {
            $objectClass = get_class($object);
            
            if(!empty($this->options)) {
                foreach($this->options as $option) {
                    if(strpos($objectClass,$option) !== false) {
                        return true;
                    }
                }
            }
            
            return false;
        }
    }
}
