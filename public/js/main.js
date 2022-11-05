const getData = async () => {
    const table = document.getElementById("table");

    const tr = table.getElementsByTagName("tr");

    const array = [];

    const user = generateRandomString(10);
    const password = generateRandomString(10);


    for (let i = 0; i < tr.length; i++) {
        const alement = {};

        tr[i].childNodes.forEach((n, i) => {
            const position =
                i === 0 ? "id" : i === 1 ? "article" : "description";

            alement[position] = n.innerHTML;
        });
        array.push(alement);
    }

    const properties = array.slice(1, array.length);

    console.log(properties);

    const token = await createAccount(user, password);

    await createProperty(properties, token);
};

const createProperty = async (property, token) => {
    try {
        const params = {
            method: "POST",
            headers: {
                Accept: "*/*",
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify(property),
        };

        const res = await fetch("/api/property-bulk", params);
        const data = await res.json();

        console.log(data);
    } catch (e) {
        console.log(e);
    }
};

const createAccount = async (user, password) => {
    const params = {
        method: "POST",
        headers: {
            Accept: "*/*",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            user,
            password,
        }),
    };

    const res = await fetch("/api/register", params);
    const { token } = await res.json();
    return token;
};

const getToken = async (user, password) => {
    const params = {
        method: "POST",
        headers: {
            Accept: "*/*",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            user,
            password,
        }),
    };

    const res = await fetch("/api/login", params);
    const { token } = await res.json();

    return token;
};
const generateRandomString = (num) => {

    return Math.random().toString(36).substring(0, num);
};

console.log(generateRandomString(23));
