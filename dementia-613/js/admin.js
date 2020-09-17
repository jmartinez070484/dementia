function selectImage(_node,_type,_multiple){
    var mediaFrame;
    var mediaOptions = {title:'Select a image',button: {text: 'Use this image',},multiple: _multiple ? true : false};

    if(_type){
        mediaOptions['type'] = _type
    }   
    
    mediaFrame = wp.media.frames.file_frame = wp.media(mediaOptions);

    mediaFrame.on( 'select', function() {
        var mediaFile = mediaFrame.state().get('selection').first().toJSON();
        
        if(mediaFile){
            if(!_multiple){
                var preview = _node.parentNode.children[1];

                preview.parentNode.className += preview.parentNode.className.indexOf(' has-image') === -1 ? ' has-image' : '';
                preview.style.background = 'url(\'' + mediaFile.url + '\') no-repeat center center/contain';
                _node.nextElementSibling.value = mediaFile.id;
            }
        }
    });

    mediaFrame.on('open',function(){
        var selection = mediaFrame.state().get('selection');
        var ids = [];
        
        if(!_multiple){
            ids.push(parseInt(_node.nextElementSibling.value));
        }else{

        }

        var totalIds = ids.length;

        if(totalIds){
            for(var x=0;x<totalIds;x++){
                attachment = wp.media.attachment(ids[x]);
                attachment.fetch();

                if(attachment){
                    selection.add(attachment);
                }
            }
        }
    });

    mediaFrame.open();

    return false;
}