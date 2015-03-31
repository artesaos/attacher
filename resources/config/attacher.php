<?php
# config/attacher.php
return [
	'model'    => 'Artesaos\Attacher\AttacherModel', # You can customize the model for your needs.
    'base_url' => '', # The url basis for the representation of images.
    'path'     => '/uploads/images/:id/:style/:filename', # Change the path where the images are stored.

    # Where the magic happens.
    # This is where you record what the "styles" that will apply to your image.
    # Each style takes as the parameter is one \Intervention\Image\Image
    # See more in http://image.intervention.io/
    'styles'   => [
        # Generate thumb (?x500)
        'thumb'=> function($image) 
        {
        	$image->resize(null, 500, function ($constraint) {
        	    $constraint->aspectRatio();
        	    $constraint->upsize();
        	});
        
        	return $image;
        }
    ]
];
