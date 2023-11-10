// import EateryRecommendationListener from './components/EateryRecommendationListener'

Nova.booting(() => {
  Nova.$on('resource-loaded', (resource) => {
    if (resource.resourceName !== 'eateries') {
      return;
    }

    if (resource.mode !== 'create') {
      return;
    }

    if (!window.location.search) {
      return;
    }

    const searchParams = new URLSearchParams(window.location.search);

    const map = {
      place_name: 'name-create-eatery-text-field',
      place_location: 'address-address',
      place_web_address: 'website-contact-details-url-field',
      place_venue_type_id: 'venue_type_id',
      place_details: 'info-details-textarea-field',
    };

    setTimeout(() => {
      Object.keys(map).forEach((key) => {
        if (searchParams.has(key)) {
          document.getElementById(map[key]).value = searchParams.get(key);
        }
      });
    }, 500);
  });
});
