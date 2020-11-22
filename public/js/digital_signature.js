async function generateKey() {
    const key = await window.crypto.subtle.generateKey({
            name: "RSASSA-PKCS1-v1_5",
            modulusLength: 4096,
            publicExponent: new Uint8Array([0x01, 0x00, 0x01]),
            hash: {
                name: "SHA-512"
            },
        },
        true,
        ["sign", "verify"]
    );

    return {
        privateKey: await window.crypto.subtle.exportKey(
            "jwk",
            key.privateKey,
        ),
        publicKey: await window.crypto.subtle.exportKey(
            "jwk",
            key.publicKey,
        ),
    };
}

async function sign(privateKeyJwk, message) {
    const privateKey = await window.crypto.subtle.importKey("jwk", privateKeyJwk, {
        name: "RSASSA-PKCS1-v1_5",
        hash: {name: "SHA-512"},
    }, false, ['sign']);
    const data = new TextEncoder().encode(message);

    const signature = await window.crypto.subtle.sign({
            name: "RSASSA-PKCS1-v1_5",
        },
        privateKey,
        data,
    );

    // converts the signature to a colon seperated string
    return new Uint8Array(signature).join(':');
}


async function verify(publicKeyJwk, signatureStr, message) {
    const signatureArr = signatureStr.split(':').map(x => +x);
    const signature = new Uint8Array(signatureArr).buffer

    const publicKey = await window.crypto.subtle.importKey("jwk", publicKeyJwk, {
        name: "RSASSA-PKCS1-v1_5",
        hash: {name: "SHA-512"},
    }, false, ['verify']);
    const data = new TextEncoder().encode(message);

    const ok = await window.crypto.subtle.verify({
            name: "RSASSA-PKCS1-v1_5",
        },
        publicKey,
        signature,
        data
    );
    return ok;
}