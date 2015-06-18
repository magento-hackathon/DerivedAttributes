<?php
use Hackathon\DerivedAttributes\BridgeInterface\EntityIteratorInterface;
use Hackathon\DerivedAttributes\Store;

class Hackathon_DerivedAttributes_Model_Bridge_EntityIterator implements EntityIteratorInterface
{
    /**
     * @var Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    protected $_collection;
    /**
     * @var string[]
     */
    protected $_data;
    /**
     * @var int Iteration counter
     */
    protected $_iteration;
    /**
     * @var Store
     */
    protected $_store;
    /**
     * @var int Iteration counter offset for chunking
     */
    protected $_iterationOffset = 0;

    public function __construct(Varien_Data_Collection_Db $collection)
    {
        $this->_collection = $collection;
    }
    public function getCollection()
    {
        return $this->_collection;
    }
    /**
     * @param callable $callable
     * @return mixed
     */
    public function walk(callable $callable)
    {
        $this->_collection->clear()
            ->setStoreId((string) $this->_store)
            ->load();
        //TODO: load all ids, then chunk
        $this->_iteration = 0;
        foreach ($this->_collection as $entity) {
            ++$this->_iteration;
            $this->_setRawData($entity->getData());
            unset($entity);
            $callable($this);
        }
    }

    protected function _setRawData($data)
    {
        $this->_data = $data;
        $this->_data['store_id'] = (string) $this->_store;
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

    function getStore()
    {
        return $this->_store;
    }

    function setStore(Store $store)
    {
        $this->_store = $store;
    }

}