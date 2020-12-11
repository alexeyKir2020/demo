export default {
    urlRegexp: new RegExp(/[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)?/gi),
    digitsRegexp: new RegExp(/^\d+$/),
    phoneRegexp: new RegExp(/^[+][\s+]|[\d+]$/),
    emailRegexp: new RegExp(/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/),
}
