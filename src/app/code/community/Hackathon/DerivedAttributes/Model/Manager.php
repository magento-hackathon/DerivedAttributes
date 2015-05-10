<?php
/**
 * @author Gerrit Addiks <gerrit.addiks@brille24.de>
 */

use Hackathon\DerivedAttributes\BridgeInterface\RuleInterface;
use Hackathon\DerivedAttributes\Service\Manager;
use Hackathon\DerivedAttributes\Attribute;

/**
 * Singleton model containing rule-manager.
 */
class Hackathon_DerivedAttributes_Model_Manager 
    extends Mage_Core_Model_Abstract{
    
    /**
     * @var Manager
     */
    protected $ruleManager;

    public function setRuleManager(Manager $manager){
        $this->manager = $manager;
    }

    /**
     * @return Manager
     */
    public function getRuleManager(){
        if(is_null($this->manager)){
            $ruleManager = new Manager();
            $this->setRuleManager($ruleManager);
            Mage::dispatchEvent("derivedattribute_new_rulemanager", [
                'manager_model' => $this,
                'rule_manager'  => $ruleManager
            ]);
        }
        return $this->manager;
    }

}
