
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Components
 |--------------------------------------------------------------------------
 |
 | Here we will load the Spark components which makes up the core client
 | application. This is also a convenient spot for you to load all of
 | your components that you write while building your applications.
 */

require('./../spark-components/bootstrap');

require('./home');

require('./paths'); // Display user's paths
require('./paths-creator'); // Create a new path
require('./panorama'); // Display any panorama
require('./panoramas-creator'); // Display linked panoramas and create button

require('./pano');
require('./view-uploader');
require('./panorama-chooser');
require('./shop-items');
require('./item-card');
require('./marker-attach');
require('./item');
require('./schedules');
require('./scraper');
