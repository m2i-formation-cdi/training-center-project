<?php
namespace m2i\project\Model\Entity;

class TrainingProgramsCourseDTO
{

    private static $columnMap = [
        'program_id' => 'programId',
        'course_id' => 'courseId',
        'order' => 'order'
    ];

    private $programId;
    private $courseId;
    private $order;

    public function __set($name, $value)
    {
        if (array_key_exists($name, self::$columnMap)) {
            $attributeName = self::$columnMap[$name];
            $this->$attributeName = $value;
        }
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $val) {
            $methodName = "set" . ucfirst($key);
            if (method_exists($this, $methodName)) {
                $this->$methodName($val);
            } else {
                if (array_key_exists($key, self::$columnMap)) {
                    $methodName = $methodName = "set" . ucfirst(self::$columnMap[$key]);
                    $this->$methodName($val);
                }
            }
        }
    }


    public function setProgramId($programId)
    {
        $this->programId = $programId;
        return $this;
    }

    public function getProgramId()
    {
        return $this->programId;
    }

    public function setCourseId($courseId)
    {
        $this->courseId = $courseId;
        return $this;
    }

    public function getCourseId()
    {
        return $this->courseId;
    }

    public function setOrderId($order)
    {
        $this->order = $order;
        return $this;
    }

    public function getOrderId()
    {
        return $this->order;
    }


}