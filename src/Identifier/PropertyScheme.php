<?php
namespace qtil\Identifier {
    class PropertyScheme extends Scheme {
        function applies($object) {
            if(!empty($this->options)) {
                foreach($this->options as $option) {
                    if(property_exists($object,$option)) {
                        return true;
                    }
                }
            }
            
            return false;
        }
        
    }
}
