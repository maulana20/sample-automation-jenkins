const express = require('express');
const cors = require("cors");
const app = express();
const options = {
  origin: '*'
};

app.use(cors(options));

app.get("/", (req, res) => {
  res.status(200).send(`selamat datang di web saya ${process.env.APP_NAME}`);
});

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => console.log(`Server started on port ${PORT}`));