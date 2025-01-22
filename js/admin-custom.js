document.addEventListener("mouseover", function(e) {
    // Selector to preview block where you want to show background image
    const previewContainer = document.querySelector('.block-editor-inserter__preview-content-missing');

    if (!previewContainer) {
        return;
    }

    if (e.target.closest('.block-editor-block-types-list__item')) {
        const hoveredBlock = e.target.closest('.block-editor-block-types-list__item');

        // to find a name of the block we can extract it from block classes

        // Retrieve classes from the block on which the mouse is hovered
        const blockClasses = hoveredBlock.className.split(' ');

        // Finding a class that starts with "editor-block-list-item-acf-"
        const blockClass = blockClasses.find(cls => cls.startsWith("editor-block-list-item-acf-"));

        // If such a class is found, extract the name from it
        if (blockClass) {
            const blockName = blockClass.replace("editor-block-list-item-acf-", "");

            const preimageUrl = wp.data.select('core/blocks').getBlockType("acf/" + blockName)?.attributes?.previewImage?.default;
            //Not ideal to make two const, but you get the idea, the next line write the absolute URL with the theme folder as template
            const imageUrl = passed_data.templateUrl+'/tpl-acf-blocks/'+blockName+'/'+preimageUrl;

            // adding our styles if there is a link to the picture
            if (imageUrl) {
                previewContainer.style.background = `url(${imageUrl}) no-repeat center`;
                previewContainer.style.backgroundSize = 'contain';
                previewContainer.style.fontSize = '0px';
            } else {
                // remove our styles if there is no link
                previewContainer.style.background = '';
                previewContainer.style.backgroundSize = '';
                previewContainer.style.fontSize = '';
            }
        }
    }
});