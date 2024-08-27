tinymce.init({
    selector: 'textarea#description, textarea#inputSpecification, textarea#outputSpecification, textarea#note, textarea#video-description, textarea#course-description',
    plugins: 'preview importcss searchreplace autolink save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl',
    toolbar_sticky: true,
    height: 400,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_class: 'mceNonEditable',
    toolbar_mode: 'sliding',
    contextmenu: 'link image table',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
    branding: false,
    promotion: false,
    quickbars_insert_toolbar: '',
    setup: function(editor) {
        editor.on('change', function() {
            editor.save();
        });
    }
});