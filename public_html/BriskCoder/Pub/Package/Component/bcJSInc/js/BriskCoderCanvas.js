/**
 * bc
 *
 * NOTICE OF LICENSE
 *
 * @category    Library
 * @package     BriskCoder Canvas JS
 * @internal    Xpler Corporation Staff Only
 * @copyright   Copyright (c) 2015 Xpler Corporation. (http://www.xpler.com)
 * @license     http://www.briskcoder.com/license/  proprietary license, All rights reserved.
 */

var bcCanvas = {
    version: 1.0,
    explode: function ( Id ) {//explode image or video tiles
        // bc.selector(container).setAttribute({display:'none'});//enforce hide
        var srcEl = Id + ':first-child';
        var containerId = bc.selector(Id).getAttribute('id');
        var srcType = bc.selector(srcEl).getTagName();
        var srcWidth = bc.selector(srcEl).getWidth();
        var srcHeight = bc.selector(srcEl).getHeight();
        
        bc.selector(srcEl).append('<canvas id="' + containerId + '-copy" width="' + srcWidth + '" height="' + srcHeight + '"></canvas>');
        bc.selector(srcEl).after('<canvas id="' + containerId + '-output" width="' + srcWidth + '" height="' + srcHeight + '"></canvas>');
        
        
        var canvasCopyId = Id + '-copy';
        var canvasOutputId = Id + '-output';
        
        console.log(canvasOutputId);
        

            bc.selector(canvasOutputId).setStyle( {background: '#000'} );

        
        
        

        
       
        //bc.thisNode[0].remove();
//        var canvasCopy = bc.thisNode[0].getContext('2d');
//        
//        var canvasOutputId = containerId + '-output';
//        bc.selector(canvasOutputId);
//        var canvasOutput = bc.thisNode[0].getContext('2d');
        


//        if (sourceType === 'VIDEO') {
//           
//            bc.thisNode[0].addEventListener('loadedmetadata', function (e) {
//                sourceWidth = this.videoWidth;
//                sourceHeight = this.videoHeight;
//                console.log(sourceHeight);
//            }, false);
//
//        }

        

    }
};