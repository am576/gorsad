<?php

namespace App\Console\Commands;

use App\Image;
use App\Product;
use App\ProductVariant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReverseProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:reverse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        Product::where('id','!=',0)
            ->delete();
        DB::table('products_attributes')
            ->where('product_id','!=',1)
            ->delete();
        ProductVariant::where('product_id','!=',1)
            ->delete();

        //$images = Image::where('imageable_type','App\Product')->delete();
        $images = Image::where('imageable_type','App\Product')->get();

        foreach ($images as $image) {
            $image->deleteImages();
            $image->destroy($image->id);
        }
    }
}
