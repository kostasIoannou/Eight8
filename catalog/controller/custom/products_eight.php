<?php

class ControllerCustomProductsEight extends Controller {
  public function index() {
    // Load the model
    $this->load->model('custom/products_eight');

    // Set the data to be passed to the view
    $data['header'] = $this->load->controller('common/header');
    $data['footer'] = $this->load->controller('common/footer');
    $data['heading_title'] = 'Custom Page';
    $data['text_content'] = 'This is my custom page content.';
    
    $this->response->setOutput($this->load->view('custom/products_eight', $data));
  }

  public function fetchProducts() {
    $minRating = isset($this->request->get['minRating']) ? (float)$this->request->get['minRating'] : null;

    if ($minRating == null || $minRating == 0) {
      $minRating = null;
    }

    $page = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;
    $limit = isset($this->request->get['limit']) ? (int)$this->request->get['limit'] : 10;


    $this->load->model('custom/products_eight');

    $filteredProducts = $this->model_custom_products_eight->getProductsByRating($minRating, $page, $limit);
    $totalRecords = $this->model_custom_products_eight->getTotalProductsByRating($minRating);

    $json['products'] = $filteredProducts;
    $json['totalRecords'] = $totalRecords;

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function checkStockAvailability() {

    $this->load->model('catalog/product');

    $product_id = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : null;
    $selected_option_id = isset($this->request->get['selected_option_id']) ? (int)$this->request->get['selected_option_id'] : null;
    $quantity = isset($this->request->get['quantity']) ? (int)$this->request->get['quantity'] : null;

    $product_options = $this->model_catalog_product->getProductOptions($product_id);
    $selected_option = null;
    

    foreach ($product_options as $option) {
        if ($option['name'] =='Radio') {
           foreach ($option['product_option_value'] as $option_value) {
              if ($option_value['product_option_value_id'] == $selected_option_id) {
                  $selected_option = $option_value;
                  break;
              }
           }
           break;
        }
    }

    // Check if the selected option and quantity are valid
    if (!$selected_option || $quantity < 1) {
      $response = array('error' => 'Invalid parameters');
    } else {
      // Check stock availability
      if ($selected_option['subtract'] && $selected_option['quantity'] < $quantity) {
          $response = array('error' => 'Out of stock');
      } else {
          $response = array('success' => 'In stock');
      }
    }

    // Return the JSON response
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($response));
		
	}
}