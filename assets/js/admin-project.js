/**
 * Photo pickers for the "Project details" box (Projects > Add/Edit project).
 * "Choose photo" opens the Media Library; picking a photo stores its ID in the
 * hidden field next to the button and shows a preview. functions.php saves
 * that ID when the project is saved.
 */
document.addEventListener('click', function (event) {
  var chooseBtn = event.target.closest('.zm-photo-choose');
  var removeBtn = event.target.closest('.zm-photo-remove');
  if (!chooseBtn && !removeBtn) return;

  event.preventDefault();
  var box = event.target.closest('.zm-photo');
  var field = box.querySelector('.zm-photo-id');
  var preview = box.querySelector('.zm-photo-preview');

  if (removeBtn) {
    field.value = '';
    preview.innerHTML = '';
    return;
  }

  // wp.media is WordPress's Media Library window.
  var frame = wp.media({
    title: 'Choose a photo',
    button: { text: 'Use this photo' },
    library: { type: 'image' },
    multiple: false
  });

  frame.on('select', function () {
    var photo = frame.state().get('selection').first().toJSON();
    // Prefer the medium size for the preview; small uploads only have the full size.
    var url = photo.sizes && photo.sizes.medium ? photo.sizes.medium.url : photo.url;

    field.value = photo.id;
    preview.innerHTML = '';
    var img = document.createElement('img');
    img.src = url;
    img.alt = '';
    img.style.cssText = 'max-width:100%;height:auto;display:block;';
    preview.appendChild(img);
  });

  frame.open();
});
