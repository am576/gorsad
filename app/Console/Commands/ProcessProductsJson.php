<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;
use Fomvasss\Punycode\Facades\Punycode;
use mysqli;

class ProcessProductsJson extends Command
{

    protected $signature = 'json:process';

    protected $description = 'Process converted .ods file to a valid product json file';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*$json_string = file_get_contents('gorsad_products.json');
        $json_data = json_decode($json_string, true);

        $products = [];

        foreach ($json_data as $key => $product) {
            unset($product['articul']);
            unset($product['height2']);
            unset($product['age']);
            unset($product['package_weight']);
            unset($product['price_eu']);
            unset($product['field15']);
            unset($product['field17']);
            unset($product['field18']);

            if(!is_numeric($product['price']))
            {
                $price = str_replace(',', '.', $product['price']);
                $price = preg_replace("/[^0-9.]/", "", $price);
                if($price)
                {
                    $product['price'] = $price;
                }
                else
                {
                    unset($product['price']);
                }
            }
            if($product['name_latin'] != '')
            {
                $product['variants'] = [];

                array_push($product['variants'],
                [
                    "crown_type" => $product['crown_type'],
                    "width" => $product['width'],
                    "height" => $product['height'],
                    "package_type" => $product['package_type'],
                ]);

                if(isset($product['price']))
                {
                    $product['variants'][0]['price'] = $product['price'];
                    unset($product['price']);
                    if($product['width'] != '')
                    {
                        $product['variants'][0]['variant_type'] = 'width';
                    }
                    if($product['height'] != '')
                    {
                        $product['variants'][0]['variant_type'] = 'height';
                    }
                }
                unset($product['crown_type']);
                unset($product['width']);
                unset($product['height']);
                unset($product['package_type']);
                array_push($products, $product);
            }
            else
            {
                if(isset($product['price']))
                {
                    if($product['width'] != '')
                    {
                        $product['variant_type'] = 'width';
                    }
                    if($product['height'] != '')
                    {
                        $product['variant_type'] = 'height';
                    }

                    unset($product['name_latin']);
                    unset($product['name_rus']);
                    unset($product['description']);
                    unset($product['image_url']);

                    array_push($products[count($products) - 1]['variants'], $product);
                }
            }
        }

        foreach ($products as $key => $product) {
            $width_count = 0;
            $height_count = 0;
            foreach ($product['variants'] as $variant) {
                if(isset($variant['variant_type']))
                {
                    if($variant['variant_type'] == 'width')  $width_count++;
                    if($variant['variant_type'] == 'height') $height_count++;
                }
                else
                {
                    continue;
                }

            }
            $products[$key]['variation'] = $width_count > $height_count ? 'width' : 'height';
        }

        $newJsonString = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents('products.json','');
        file_put_contents('products.json',$newJsonString);
        echo(count($products) . "\n");*/

        ### Запись товаров в базу ###

        $json_string = file_get_contents('products.json');
        $json_data = json_decode($json_string, true);

        ## Загрузка картинок ##
        foreach ($json_data as $product) {
            if(isset($product['image_url']) && $product['image_url'] != "")
            {
                $path = $product['image_url'];
                $parsed_url = parse_url($path);
                if(!file_exists('/home/am/wp_uploads/'.$parsed_url['path']))
                {
                    if(isset($parsed_url['scheme']) && isset($parsed_url['host']) && isset($parsed_url['path']))
                    {
                        $url = $parsed_url['scheme'].'://'.Punycode::encode($parsed_url['host']).$parsed_url['path'];
                        var_dump($url);
                        try {
                            $filename = basename($url);
                            echo $filename . "\n";
                            Image::make($url)->save('/home/am/wp_uploads/' . $filename);
                        }
                        catch (\Exception $e)
                        {

                        }
                    }
                }

            }
        }

        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "r00t";
        $db = "gorsad_sad";
        date_default_timezone_set("Europe/Kiev");
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $mysqli -> error);

        foreach ($json_data as $product) {

            $variants = $product['variants'];
            $variant_type = $product['variation'];
            $name_rus = $product['name_rus'];
            $taxonomy = $variant_type == 'height' ? 'pa_vysota' : 'pa_obxvat-stvola';
            $post_name = str_slug($name_rus);
            $post_content = $product['description'];

            $now = new DateTime();
            $dt = $now->format('Y-m-d H:i:s');
            $dt_gmt = $now->modify('-3 hours')->format('Y-m-d H:i:s');

            $mysqli->query("INSERT INTO wp_posts (post_author, post_title, post_name, post_excerpt, post_type, post_status, ping_status, comment_status, post_date, post_date_gmt, post_modified, post_modified_gmt)
                                VALUES (1, '$name_rus', '$post_name', '$post_content', 'product', 'publish', 'closed', 'closed', '$dt', '$dt_gmt', '$dt', '$dt_gmt' )");

            $product_id = $mysqli->insert_id;
            echo "product_id = " . $product_id . "\n";
            $guid = 'http://gorsad39.ru/?post_type=product&#038;p=' . $product_id;

            if(isset($product['image_url']) && $product['image_url'] != "")
            {
                $image_url = $product['image_url'];
                $parsed_url = parse_url($image_url);
                if(isset($parsed_url['scheme']) && isset($parsed_url['host']) && isset($parsed_url['path']))
                {
                    $url = $parsed_url['scheme'].'://'.Punycode::encode($parsed_url['host']).$parsed_url['path'];
                    $image_filename =  'https://gorsad39.ru/wp-content/uploads/2021/09/' . basename($url);

                    $mysqli->query("INSERT INTO wp_posts (post_title, post_name, post_parent, guid, post_type, post_status, comment_status, ping_status, post_mime_type, post_date, post_date_gmt, post_modified, post_modified_gmt)
                                    VALUES ('$name_rus', '$post_name', '$product_id', '$image_filename', 'attachment', 'publish', 'closed', 'closed', 'image/jpeg', '$dt', '$dt_gmt', '$dt', '$dt_gmt')");
                    $image_id = $mysqli->insert_id;
                    $image_path = '2021/09/' . basename($url);

                    $mysqli->query("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ('$image_id', '_wp_attached_file', '$image_path')");
                    $mysqli->query("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ('$product_id', '_thumbnail_id', '$image_id')");
                }
            }

            $mysqli->query("UPDATE wp_posts SET guid = '$guid' WHERE id = '$product_id'");

            $mysqli->query("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES ('$product_id', 84, 0); ");
            $mysqli->query("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES ('$product_id', 4, 0); ");

            if(isset($product['variants'][0]['crown_type']))
            {
                $crown_type = $product['variants'][0]['crown_type'];
                if($crown_type != '')
                {
                    switch ($crown_type) {
                        case 'St':
                            $tax_id = 270;
                            break;
                        case 'Mst':
                            $tax_id = 272;
                            break;
                        case 'Sol':
                            $tax_id = 273;
                            break;
                        case 'StBu':
                            $tax_id = 271;
                            break;
                        case 'Wh':
                            $tax_id = 274;
                            break;
                    }
                    $ids = $mysqli->query("SELECT ID from wp_posts where post_title = '$name_rus' and post_type = 'product'");
                    $res = $ids->fetch_all(MYSQLI_ASSOC);
                    if(count($res))
                    {
                        $pr_id = $res[0]['ID'];
                        if($variant_type) {
                            if($variant_type == 'height')
                            {
                                $pr_attrs = 'a:2:{s:9:"pa_vysota";a:6:{s:4:"name";s:9:"pa_vysota";s:5:"value";s:0:"";s:8:"position";i:0;s:10:"is_visible";i:1;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:1;}s:8:"pa_crown";a:6:{s:4:"name";s:8:"pa_crown";s:5:"value";s:0:"";s:8:"position";i:1;s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}}';
                            }
                            if ($variant_type == 'width')
                            {
                                $pr_attrs = 'a:2:{s:16:"pa_obxvat-stvola";a:6:{s:4:"name";s:16:"pa_obxvat-stvola";s:5:"value";s:0:"";s:8:"position";i:0;s:10:"is_visible";i:1;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:1;}s:8:"pa_crown";a:6:{s:4:"name";s:8:"pa_crown";s:5:"value";s:0:"";s:8:"position";i:1;s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}}';
                            }
                            $mysqli->query("UPDATE wp_postmeta SET meta_value = '$pr_attrs' where post_id = '$pr_id' and meta_key = '_product_attributes'");
                        }

//                        $mysqli->query("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES ('$pr_id', '$tax_id', 0); ");
//                        echo 'Inserted crown type = ' . $crown_type . ' with id = ' . $mysqli->insert_id . "\n";
                    }
                }
            }
            /*$product_crown_type = isset($product['variants'][0]['crown_type']) ? $product['variants'][0]['crown_type'] : "";
            $product_meta_height = 'a:1:{s:9:"pa_vysota";a:6:{s:4:"name";s:9:"pa_vysota";s:5:"value";s:0:"";s:8:"position";i:0;s:10:"is_visible";i:1;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:1;}}';
            $product_meta_width = 'a:1:{s:16:"pa_obxvat-stvola";a:6:{s:4:"name";s:16:"pa_obxvat-stvola";s:5:"value";s:0:"";s:8:"position";i:2;s:10:"is_visible";i:1;s:12:"is_variation";i:1;s:11:"is_taxonomy";i:1;}}';

            $product_meta_attrs = $variant_type == 'height' ? $product_meta_height : $product_meta_width;
            $mysqli->query("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ('$product_id', '_product_attributes', '$product_meta_attrs')");

            $variants_type = [
                'height' => 'Высота',
                'width' => 'Обхват ствола'
            ];

            $meta_attrs_type = [
                'height' => 'attribute_pa_vysota',
                'width' => 'attribute_pa_obxvat-stvola'
            ];
            $variant_prices = [];
            foreach ($variants as $variant) {
                if(!isset($variant['price']) || !isset($variant[$variant_type]) || !$variant[$variant_type])
                {
                    continue;
                }
                $var_param = $variant[$variant_type] . ' см';
                $meta_param = $variant[$variant_type] . '-sm';
                $variant_price = $variant['price'];
                array_push($variant_prices, $variant_price);

                $post_title = $name_rus . ' - ' . $var_param;
                $post_excerpt = $variants_type[$variant_type] . ': ' . $var_param;

                $mysqli->query("INSERT INTO wp_posts (post_author, post_title, post_excerpt, post_parent, post_type, post_status, ping_status, comment_status, post_date, post_date_gmt, post_modified, post_modified_gmt)
                                  VALUES (1, '$post_title', '$post_excerpt', '$product_id', 'product_variation', 'publish', 'closed', 'closed', '$dt', '$dt_gmt', '$dt', '$dt_gmt' )");

                $variant_id = $mysqli->insert_id;

                $mysqli->query("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ('$variant_id', '$meta_attrs_type[$variant_type]', '$meta_param')");

                $mysqli->query("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ('$product_id', '_price', '$variant_price')");
                $mysqli->query("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ('$product_id', '_regular_price', '$variant_price')");
                $mysqli->query("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ('$variant_id', '_price', '$variant_price')");
                $mysqli->query("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES ('$variant_id', '_regular_price', '$variant_price')");

                $term_ids = $mysqli->query("SELECT term_id FROM wp_terms WHERE name LIKE '%$var_param%'");
                $entries = $term_ids->fetch_all(MYSQLI_ASSOC);
                $term_ids->close();
                if (count($entries)) {
                    $taxonomy_ids = $mysqli->query("SELECT wp_term_taxonomy.term_taxonomy_id FROM wp_terms
                                                JOIN wp_term_taxonomy on wp_terms.term_id = wp_term_taxonomy.term_id
                                                WHERE name LIKE '%$var_param%'
                                                AND taxonomy LIKE '$taxonomy%'");
                    $res = $taxonomy_ids->fetch_all(MYSQLI_ASSOC);
                    if(count($res))
                    {
                        $taxonomy_id = $res[0]['term_taxonomy_id'];
                    }
                    else
                    {
                        $mysqli->query("INSERT INTO wp_terms (name, slug) VALUES ('$var_param', '$meta_param')");
                        $tid = $mysqli->insert_id;
                        $mysqli->query("INSERT INTO wp_term_taxonomy (term_id, taxonomy) VALUES ('$tid', '$taxonomy')");
                        $taxonomy_id = $mysqli->insert_id;
                    }

                    $taxonomy_ids->close();
                }
                else
                {
                    $mysqli->query("INSERT INTO wp_terms (name, slug) VALUES ('$var_param', '$meta_param')");
                    $tid = $mysqli->insert_id;
                    $mysqli->query("INSERT INTO wp_term_taxonomy (term_id, taxonomy) VALUES ('$tid', '$taxonomy')");
                    $taxonomy_id = $mysqli->insert_id;
                }
                $mysqli->query("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES ('$product_id', '$taxonomy_id', 0); ");
            }*/

        }

        $mysqli->close();

        return 0;
    }
}
