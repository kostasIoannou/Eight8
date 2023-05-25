<?php
class ModelCustomProductsEight extends Model {
    public function getProductsByRating($minRating, $page, $limit) {
        $this->load->model('catalog/product');
        $this->load->model('tool/image'); // Load the image model

        $sql = "SELECT * FROM " . DB_PREFIX . "product_avg_rating";

        if (!is_null($minRating)) {
            $sql .= " WHERE avg_rating <= " . (float)$minRating;
        }

        // Add pagination limits to the query
        $start = ($page - 1) * $limit; // Set the limit to 10
        $sql .= " LIMIT " . $start . "," . $limit;

        $query = $this->db->query($sql);

        $filteredProducts = array();

        foreach ($query->rows as $row) {
            $product = $this->model_catalog_product->getProduct($row['product_id']);

            if ($product) {
                $image = $this->model_tool_image->resize($product['image'], 228, 228); // Use image cache URL

                $filteredProducts[] = array(
                    'url' => $this->url->link('product/product', 'product_id=' . $row['product_id']),
                    'image' => $image,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'avg_rating' => $row['avg_rating']
                );
            }
        }

        return $filteredProducts;
    }

    public function getTotalProductsByRating($minRating) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_avg_rating";

        if (!is_null($minRating)) {
            $sql .= " WHERE avg_rating <= " . (float)$minRating;
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }
}
?>
