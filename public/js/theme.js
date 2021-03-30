let types = {},
    select = document.querySelector('.jsSelect'),
    divInputWrappers = document.querySelectorAll('.jsInput');

types['A'] = ['name', 'content', 'ttl'];
types['AAAA'] = ['name', 'content', 'ttl'];
types['MX'] = ['name', 'content', 'prio', 'ttl'];
types['ANAME'] = ['name', 'content', 'ttl'];
types['CNAME'] = ['name', 'content', 'ttl'];
types['NS'] = ['name', 'content', 'ttl'];
types['TXT'] = ['name', 'content', 'ttl'];
types['SRV'] = ['name', 'content', 'prio', 'port', 'weight', 'ttl'];


select && select.addEventListener('change', (e) => {
    let type = types[select.value]

    divInputWrappers.forEach(div => {
        let input = div.querySelector('input'),
            includes = type.includes(input.getAttribute('name'));

        if (!includes) {
            div.classList.add('d-none')

            if (input.hasAttribute('required')) {
                input.removeAttribute('required')
            }
        } else {
            div.classList.remove('d-none')

            if (input.classList.contains('jsRequired')) {
                input.required = true;
            }
        }
    })
})