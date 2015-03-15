<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 14.03.15
 * Time: 21:23
 */

class B_Form_Decorator_DynamicTemplate extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        $element = $this->getElement();
        if(!($element instanceof B_Form_Element_Group))
            return $content;

        $template = [];
        $myElements = $element->getElements();
        foreach($myElements as $item) {
            if($item instanceof Zend_Form_Element_Xhtml) {
                $decorator = $item->getDecorators();
                if(is_array($decorator))
                    foreach($decorator as $d) {
                        $decorator = $d; break; // get first element
                    }

                $clone = clone $item;
                $clone->setBelongsTo(str_replace('[0]', '[__index__]',$element->getName()));
                $clone->setAttrib('id',null);

                $decorator->setElement($clone);
                $template[] = '<element name="'. $clone->getName()
                    .'">'.$decorator->render('').'</element>';
            }
        }
        $template = '<span data-template="'.htmlspecialchars( join('', $template) ).'" id="'.
            str_replace('[0]','',$this->getElement()->getName()).'-template"></span>';
        return $template.' '.$content;
    }
}
