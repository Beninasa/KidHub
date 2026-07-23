(() => {
  "use strict";

  const link = document.querySelector(
    ".kidhub-checkout__continue-shopping"
  );

  if (!link) {
    return;
  }

  let frameId = 0;

  const placeLink = () => {
    const actions = document.querySelector(
      ".wc-block-checkout__actions_row"
    );

    if (!actions) {
      return;
    }

    actions.classList.add("kidhub-checkout__actions-row");

    if (link.parentElement !== actions) {
      actions.append(link);
    }
  };

  const schedulePlacement = () => {
    if (frameId) {
      return;
    }

    frameId = window.requestAnimationFrame(() => {
      frameId = 0;
      placeLink();
    });
  };

  placeLink();

  const checkout = document.querySelector(
    ".wp-block-woocommerce-checkout"
  );

  if (!checkout) {
    return;
  }

  const observer = new MutationObserver(schedulePlacement);

  observer.observe(checkout, {
    childList: true,
    subtree: true,
  });
})();
