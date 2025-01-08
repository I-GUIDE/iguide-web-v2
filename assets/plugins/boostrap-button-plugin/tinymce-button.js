(function () {
    tinymce.create('tinymce.plugins.my_custom_button_plugin', {
        init: function (editor, url) {
            editor.addButton('my_custom_button', {
                title: 'Insert Bootstrap Button',
                image: url + '/images/btn.svg',
                icon: false,
                onclick: function () {
                    openDialog(editor);
                },
            });

            // Function to create and open the dialog
            const openDialog = (editor) => {
                editor.windowManager.open({
                    title: 'Insert Bootstrap Button',
                    body: [
                        {
                            type: 'textbox',
                            name: 'text', // Field name for button text
                            label: 'Button Text',
                            value: 'Click Me', // Default value
                        },
                        {
                            type: 'textbox',
                            name: 'url', // Field name for button URL
                            label: 'Button URL',
                            value: 'http://', // Default value
                        },
                        {
                            type: 'listbox',
                            name: 'style', // Field name for button style
                            label: 'Button Style',
                            values: [
                                { text: 'Blue (Primary)', value: 'btn-primary' },
                                { text: 'Grey (Secondary)', value: 'btn-secondary' },
                                { text: 'Green (Success)', value: 'btn-success' },
                                { text: 'Red (Danger)', value: 'btn-danger' },
                                { text: 'Yellow (Warning)', value: 'btn-warning' },
                                { text: 'Light Blue (Info)', value: 'btn-info' },
                                { text: 'Light (Light)', value: 'btn-light' },
                                { text: 'Dark (Dark)', value: 'btn-dark' },
                            ],
                        },
                    ],
                    onsubmit: function (e) {
                        // Retrieve data from the dialog
                        const data = e.data;

                        console.log(data);

                        // Validate the input data
                        if (!data.text || !data.url) {
                            alert('Please fill in both Button Text and URL.');
                            return;
                        }

                        // Create the button HTML
                        const buttonHtml = `<a href="${data.url}" class="btn ${data.style}">${data.text}</a>`;

                        // Insert the HTML into the editor
                        editor.insertContent(buttonHtml);
                    },
                });
            };
        },
        createControl: function (n, cm) {
            return null;
        },
    });

    tinymce.PluginManager.add('my_custom_button', tinymce.plugins.my_custom_button_plugin);
})();
