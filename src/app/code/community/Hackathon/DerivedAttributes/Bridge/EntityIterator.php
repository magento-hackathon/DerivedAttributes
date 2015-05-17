<?php
use Hackathon\DerivedAttributes\BridgeInterface\EntityIteratorInterface;
class Hackathon_DerivedAttributes_Bridge_EntityIterator implements EntityIteratorInterface
{
    /**
     * @var Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected $_collection;
    /**
     * @var Mage_Core_Model_Resource_Iterator
     */
    protected $_iterator;
    /**
     * @var string[]
     */
    protected $_data;
    /**
     * @var int Iteration counter
     */
    protected $_iteration;
    /**
     * @var int Iteration counter offset for chunking
     */
    protected $_iterationOffset = 0;

    public function __construct(Varien_Data_Collection_Db $collection)
    {
        $this->_collection = $collection;
        $this->_iterator = Mage::getResourceModel('core/iterator');
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    /**
     * @param callable $callable
     * @return mixed
     */
    function walk(callable $callable)
    {
        $this->_iterator->walk($this->_collection->getSelect(), array(
            function($args) use ($callable) {
                $this->_setIteration($args['idx']);
                $this->_setRawData($args['row']);
                $callable($this);
            }
        ));
    }

    protected function _setRawData($data)
    {
        $this->_data = $data;
    }
    protected function _setIteration($iteration)
    {
        $this->_iteration = $iteration;
    }
    public function setIterationOffset($offset)
    {
        $this->_iterationOffset = $offset;
    }

    /**
     * Returns raw data from database
     *
     * @return mixed
     */
    function getRawData()
    {
        return $this->_data;
    }

    /**
     * Returns number of iteration
     *
     * @return int
     */
    function getIteration()
    {
        return $this->_iterationOffset + $this->_iteration;
    }

    /**
     * Returns total size of collection
     *
     * @return mixed
     */
    function getSize()
    {
        return $this->_collection->getSize();
    }

}