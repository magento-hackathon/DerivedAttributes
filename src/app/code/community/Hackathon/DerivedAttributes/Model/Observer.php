<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

/**
 * Event-observer for derived attributes.
 */
class Hackathon_DerivedAttributes_Model_Observer{
    
    public function beforeModelSave(Varien_Object $observer){

        /* @var $modelObject Mage_Core_Model_Abstract */
        $modelObject = $observer->getObject();

        $modelResource = $modelObject->getResource();

        if($modelResource instanceof Mage_Eav_Model_Entity_Abstract){

            /* @var $ruleModel Hackathon_DerivedAttributes_Model_Rule */
            $ruleModel = Mage::getModel("derivedattributes/rule");
            
            /* @var $ruleCollection Mage_Core_Model_ */
            $ruleCollection = $ruleModel->getCollection();
            
            foreach($modelResource->getAttributesByCode() as $code => $attribute){
                /* @var $attribute Mage_Eav_Model_Entity_Attribute */

                if(!is_null($attribute->getId())){

                }
            }
            
        }

    }

}
