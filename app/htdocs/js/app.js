{
    'use strict';

    document.querySelectorAll('input, textarea').forEach(index => {
        new RealtimeValidationView(index);
    });
}