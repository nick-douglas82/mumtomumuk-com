let website = window.location.hostname;

let internalLinkRegex = new RegExp('^((((http:\\/\\/|https:\\/\\/)(www\\.)?)?'
    + website
    + ')|(localhost:\\d{4})|(\\/.*))(\\/.*)?$', '');

let anchorEls = document.querySelectorAll('a');
let anchorElsLength = anchorEls.length;

for (let i = 0; i < anchorElsLength; i++) {
    let anchorEl = anchorEls[i];

    if ( ! anchorEl.classList.contains('review__link') ) {
        let href = anchorEl.getAttribute('href');

        if (!internalLinkRegex.test(href)) {
            anchorEl.setAttribute('target', '_blank');
        }

    }
}