<?php
namespace qtil\Identifier {
    class ClassScheme extends Scheme {
        function applies($object) {
            $objectClass = get_class($object);
            
            return in_array($objectClass,$this->options);
        }
    }
}
