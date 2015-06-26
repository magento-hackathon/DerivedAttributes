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
     * @var Iterator
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
     * @deprecated use iterator interface instead
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

    /**
     * @deprecated use current() of Iterator interface instead
     * @param $data
     */
    protected function _setRawData($data)
    {
        $this->_data = $data;
        $this->_data['store_id'] = (string) $this->_store;
    }

    /**
     * @param $offset
     */
    public function setIterationOffset($offset)
    {
        $this->_iterationOffset = $offset;
    }

    /**
     * Returns raw data from database
     *
     * @return mixed
     * @deprecated use current() of Iterator interface instead
     */
    function getRawData()
    {
        return $this->_data;
    }

    /**
     * Returns number of iteration
     *
     * @return int
     * @deprecated use key() of Iterator interface instead
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

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        $this->_setRawData($this->_iterator->current()->getData());
        return $this->_data;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->_iteration++;
        $this->_iterator->next();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->_iterator->key();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->_iterator->valid();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->_collection->clear()
            ->setStoreId((string) $this->_store)
            ->load();
        //TODO: load all ids, then chunk
        $this->_iteration = 0;
        $this->_iterator = $this->_collection->getIterator();
    }

}