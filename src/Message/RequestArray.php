<?php

namespace Omnipay\EveryPay\Message;

class RequestArray
{
    private $data = array();

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setBoolean($key, $value)
    {
        if ($value !== null) {
            $this->data[$key] = (int) $value;
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setInteger($key, $value)
    {
        if ($value !== null) {
            $this->data[$key] = (int) $value;
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setString($key, $value)
    {
        if ($value !== null) {
            $this->data[$key] = (string) $value;
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setJsonArray($key, $value)
    {
        if ($value !== null) {
            if (!is_array($value)) {
                $value = [$value];
            }

            $this->data[$key] = (string) json_encode($value);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setDouble($key, $value)
    {
        if ($value !== null) {
            $this->data[$key] = $this->serializeDouble($value);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setDate($key, $value)
    {
        if ($value !== null) {
            $this->data[$key] = $this->serializeDate($value);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setTime($key, $value)
    {
        if ($value !== null) {
            $this->data[$key] = $this->serializeTime($value);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setUnixTimestamp($key, $value)
    {
        if ($value !== null) {
            $this->data[$key] = $this->serializeUnixTimestamp($value);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setTimestamp($key, $value)
    {
        if ($value !== null) {
            $this->data[$key] = $this->serializeTimestamp($value);
        }

        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setArray($data)
    {
        if (!empty($data)) {
            foreach ($data as $index => $line) {
                foreach ($line->serialize() as $key => $value) {
                    $this->data[$key.($index+1)] = $value;
                }
            }
        }

        return $this;
    }

    private function serializeDate(\DateTime $value = null)
    {
        if (empty($value)) {
            return "";
        }

        return $value->format('Y-m-d');
    }

    private function serializeTime(\DateTime $value = null)
    {
        if (empty($value)) {
            return "";
        }

        return $value->format('H:i:s');
    }

    private function serializeUnixTimestamp(\DateTime $value = null)
    {
        if (empty($value)) {
            return "";
        }

        return $value->getTimestamp();
    }

    private function serializeTimestamp(\DateTime $value = null)
    {
        if (empty($value)) {
            return "";
        }

        return date_format($value, 'c');
    }

    private function serializeDouble($value = null)
    {
        if (empty($value) || $value === 0) {
            return "";
        }

        return number_format($value, 2, '.', '');
    }
}
