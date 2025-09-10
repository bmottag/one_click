"use strict";

// Class definition
var KTPricingGeneral = function () {
    // Private variables
    var element;
	var planPeriodMonthButton;
	var planPeriodAnnualButton;

    var priceIds = {
        pro: {
            month: "price_1S2uiwAZ4W6MNo33I0hfYQxF", // Pro mensual
            annual: "price_1S2uiwAZ4W6MNo338JnrsiUb" // Pro anual
        },
        full: {
            month: "price_1S2xI8AZ4W6MNo33tSWwpwR5", // Full mensual
            annual: "price_1S2xIxAZ4W6MNo33jOIEE2H8" // Full anual
        }
    };

    var changePlanPrices = function(type) {
        var items = [].slice.call(element.querySelectorAll('[data-kt-plan-price-month]'));

        items.map(function (item) {
            var monthPrice = item.getAttribute('data-kt-plan-price-month');
            var annualPrice = item.getAttribute('data-kt-plan-price-annual');
            var th = item.closest('th');
            var button = th.querySelector('a[data-price-id]');
            var plan = th.getAttribute('data-plan');

            if (type === 'month') {
                item.innerHTML = monthPrice;
                if (button) {
                    button.setAttribute('data-period', 'month');
                    button.setAttribute('data-price-id', priceIds[plan].month);
                    button.setAttribute('data-plan', plan); 
                }
            } else if (type === 'annual') {
                item.innerHTML = annualPrice;
                if (button) {
                    button.setAttribute('data-period', 'annual');
                    button.setAttribute('data-price-id', priceIds[plan].annual);
                    button.setAttribute('data-plan', plan); 
                }
            }
        });
    }

    var handlePlanPeriodSelection = function(e) {

        // Handle period change
        planPeriodMonthButton.addEventListener('click', function (e) {
            e.preventDefault();

            planPeriodMonthButton.classList.add('active');
            planPeriodAnnualButton.classList.remove('active');

            changePlanPrices('month');
        });

		planPeriodAnnualButton.addEventListener('click', function (e) {
            e.preventDefault();

            planPeriodMonthButton.classList.remove('active');
            planPeriodAnnualButton.classList.add('active');
            
            changePlanPrices('annual');
        });
    }

    // Public methods
    return {
        init: function () {
            element = document.querySelector('#kt_pricing');
			planPeriodMonthButton = element.querySelector('[data-kt-plan="month"]');
			planPeriodAnnualButton = element.querySelector('[data-kt-plan="annual"]');

            // Handlers
            handlePlanPeriodSelection();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTPricingGeneral.init();
});
