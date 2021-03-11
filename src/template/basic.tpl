<script type="text/javascript">
    // const mceElf = new tinymceElfinder({
    //     // connector URL (Set your connector)
    //     url: '<?=_MODURL_?>/elfinder/dist/php/connector.minimal.php', // use an absolute path!
    //     // upload target folder hash for this tinyMCE
    //     uploadTargetHash: 'l1_lw', // Hash value on elFinder of writable folder
    //     // elFinder dialog node id
    //     nodeId: 'elfinder', // Any ID you decide
    //     baseUrl: '<?=_MODURL_?>/elfinder/dist/',
    //     lang: 'ru'
    // });

    tinymce.init({
        selector: '{{ selector }}',
        plugins: [
            'print preview  fullscreen paste importcss searchreplace autolink autosave save directionality visualblocks visualchars image link media template codesample table charmap hr nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        ],
        toolbar: 'save | fullscreen undo redo | formatselect | ' +
            ' bold italic backcolor | alignleft aligncenter ' +
            ' alignright alignjustify | bullist numlist outdent indent | link image' +
            ' removeformat  code | help',
        // file_picker_callback: mceElf.browser,
        //  images_upload_handler: mceElf.uploadHandler,
        relative_urls: false,
        remove_script_host: true,
        // document_base_url: '<?=_HTTP_URL_?>/',
        allow_script_urls: true,
        image_advtab: true,
        image_dimensions: false,
        image_class_list: [
            {title: 'None', value: ''},
            {title: 'Responsive', value: 'imgfluid'}
        ],
        language: 'ru'

    });
</script>