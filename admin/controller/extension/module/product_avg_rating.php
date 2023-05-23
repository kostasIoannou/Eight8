<?php
class ControllerExtensionModuleProductAvgRating extends Controller {
    private $error = array();

    public function install() {
        $this->load->model('extension/module/product_avg_rating');
        $this->model_extension_module_product_avg_rating->install();
    }

    public function uninstall() {
        $this->load->model('extension/module/product_avg_rating');
        $this->model_extension_module_product_avg_rating->unistall();
    }
}