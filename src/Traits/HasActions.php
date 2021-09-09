<?php


namespace YeeJiaWei\TableGenerator\Traits;

trait HasActions
{
    protected $creatable = false;
    protected $create_route_name;
    protected $viewable = false;
    protected $view_route_name;
    protected $editable = false;
    protected $edit_route_name;
    protected $deletable = false;
    protected $delete_route_name;

    public function setCreatable(string $routeName)
    {
        $this->create_route_name = $routeName;
        $this->creatable = true;

        return $this;
    }

    public function setViewable(string $routeName)
    {
        $this->view_route_name = $routeName;
        $this->viewable = true;

        return $this;
    }

    public function setEditable(string $routeName)
    {
        $this->edit_route_name = $routeName;
        $this->editable = true;

        return $this;
    }

    public function setDeletable(string $routeName)
    {
        $this->delete_route_name = $routeName;
        $this->deletable = true;

        return $this;
    }
}