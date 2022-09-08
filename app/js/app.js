{
    'use strict';

    document.querySelectorAll('input').forEach(index => {
        new RealtimeValidationView(index);
    });
}