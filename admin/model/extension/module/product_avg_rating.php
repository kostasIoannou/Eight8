<?php
class ModelExtensionModuleProductAvgRating extends Model {
    public function install() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_avg_rating` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `product_id` INT(11) NOT NULL,
                `avg_rating` FLOAT(3,2) NOT NULL,
            PRIMARY KEY(`id`)
            ) ENGINE=MyISAM DEFAULT COLLATE = utf8_general_ci;
        ");

        //At this way create a table with real data not dummy for that reason i commend it out 

        // $products = $this->db->query("SELECT `product_id` FROM `" . DB_PREFIX . "product`");

        // foreach ($products->rows as $product) {
        //     $product_id = $product['product_id'];

        //     $ratings = $this->db->query("SELECT AVG(`rating`) AS `avg_rating` FROM `" . DB_PREFIX . "review` WHERE `product_id` = " . (int)$product_id);

        //     if ($ratings->num_rows) {
        //         $avg_rating = (float)$ratings->row['avg_rating'];
        //     } else {
        //         $avg_rating = 0;
        //     }

        //     $this->db->query("
        //         INSERT INTO `" . DB_PREFIX . "product_avg_rating` (`product_id`, `avg_rating`)
        //         VALUES (" . (int)$product_id . ", " . $avg_rating . ")
        //         ON DUPLICATE KEY UPDATE `avg_rating` = " . $avg_rating . "
        //     ");
        // }

        // Insert dummy data
        for ($i = 28; $i <= 49; $i++) {
            $product_id = $i;
            $avg_rating = mt_rand(10, 50) / 10; // Generate a random float rating between 1.0 and 5.0
        
            $existingRow = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_avg_rating` WHERE `product_id` = " . (int)$product_id);
        
            // Check if the existing row exists
            if ($existingRow->num_rows) {
                // Update the existing row with the updated average rating
                $this->db->query("
                    UPDATE `" . DB_PREFIX . "product_avg_rating`
                    SET `avg_rating` = " . $avg_rating . "
                    WHERE `product_id` = " . (int)$product_id . "
                ");
                // Delete the previous rows for the product ID except the updated row
                 $this->db->query("
                    DELETE FROM `" . DB_PREFIX . "product_avg_rating`
                    WHERE `product_id` = " . (int)$product_id . " AND `id` != " . (int)$existingRow->row['id'] . "
                ");
            } else {
                // Insert a new row with the updated average rating
                $this->db->query("
                    INSERT INTO `" . DB_PREFIX . "product_avg_rating` (`product_id`, `avg_rating`)
                    VALUES (" . (int)$product_id . ", " . $avg_rating . ")
                ");
            }
        }
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "product_avg_rating`;");
    }
    
}