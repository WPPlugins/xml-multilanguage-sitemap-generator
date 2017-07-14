jQuery(document).ready(function($){
  $('input.autocomplete').autocomplete({
      data: {
        "always": null,
        "hourly": null,
        "daily": null,
        "weekly": null,
        "monthly": null,
        "yearly": null,
        "never": null
      },
      limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
      onAutocomplete: function(val) {
        // Callback function when value is autcompleted.
      },
      minLength: 0, // The minimum length of the input for the autocomplete to start. Default: 1.
    });
});