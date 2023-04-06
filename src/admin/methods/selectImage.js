export const selectImage = (event, formData) => {
    let uploader = wp.media({
        title: 'Select or Upload service icon Of Your Chosen Persuasion',
        button:{
            text: 'Use the icon'
        },
        multiple: false
    });

    if (uploader){
        uploader.open();
    }

    uploader.on("select", function () {
        let attachment = uploader.state().get('selection').first().toJSON();
        if (attachment.type === 'image'){
            formData.kcsSliderImage = attachment.url;
        }
    })
}