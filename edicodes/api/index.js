const express = require('express');
const cors = require('cors');
const nodemailer = require('nodemailer');
const bodyParser = require('body-parser');
const fs = require('fs');
const path = require('path');
const dotenv = require('dotenv');

// Load environment variables
dotenv.config();

const app = express();
const PORT = process.env.PORT || 3000;

// CORS configuration
const allowedOrigins = process.env.ALLOWED_ORIGINS 
  ? process.env.ALLOWED_ORIGINS.split(',') 
  : ['http://localhost:5173', 'https://edrisranjbar.ir'];

// Middleware
app.use(cors({
  origin: function(origin, callback) {
    // Allow requests with no origin (like mobile apps or curl requests)
    if (!origin) return callback(null, true);
    
    if (allowedOrigins.indexOf(origin) === -1) {
      const msg = 'The CORS policy for this site does not allow access from the specified Origin.';
      return callback(new Error(msg), false);
    }
    return callback(null, true);
  },
  credentials: true
}));
app.use(bodyParser.json());

// Create logs directory if it doesn't exist
const logsDir = path.join(__dirname, 'logs');
if (!fs.existsSync(logsDir)) {
  fs.mkdirSync(logsDir);
}

// Setup nodemailer transporter
const transporter = nodemailer.createTransport({
  host: process.env.MAIL_HOST || 'smtp.gmail.com',
  port: process.env.MAIL_PORT || 587,
  secure: process.env.MAIL_SECURE === 'true',
  auth: {
    user: process.env.MAIL_USER || 'your-email@gmail.com',
    pass: process.env.MAIL_PASS || 'your-email-password'
  }
});

// Contact form endpoint
app.post('/contact', async (req, res) => {
  try {
    const { name, email, subject, message, timestamp } = req.body;
    
    // Validate input
    if (!name || !email || !subject || !message) {
      return res.status(400).json({ 
        success: false, 
        message: 'لطفاً تمام فیلدها را پر کنید' 
      });
    }
    
    // Log the message to a file
    const logFile = path.join(logsDir, 'contacts.json');
    let contacts = [];
    
    if (fs.existsSync(logFile)) {
      const data = fs.readFileSync(logFile, 'utf8');
      contacts = JSON.parse(data);
    }
    
    contacts.push({
      name,
      email,
      subject,
      message,
      timestamp: timestamp || new Date().toISOString(),
      ip: req.ip
    });
    
    fs.writeFileSync(logFile, JSON.stringify(contacts, null, 2));
    
    // Send email notification
    const mailOptions = {
      from: process.env.MAIL_FROM || 'your-website@example.com',
      to: process.env.MAIL_TO || 'edrisranjbar.dev@gmail.com',
      subject: `پیام جدید از وبسایت: ${subject}`,
      html: `
        <div dir="rtl" style="font-family: Tahoma, Arial; line-height: 1.6;">
          <h2>پیام جدید از وبسایت</h2>
          <p><strong>نام:</strong> ${name}</p>
          <p><strong>ایمیل:</strong> ${email}</p>
          <p><strong>موضوع:</strong> ${subject}</p>
          <p><strong>پیام:</strong></p>
          <div style="background-color: #f5f5f5; padding: 15px; border-radius: 5px;">
            ${message.replace(/\n/g, '<br>')}
          </div>
          <p><small>این ایمیل به صورت خودکار ارسال شده است.</small></p>
        </div>
      `
    };
    
    // Only send email if we have proper credentials
    if (process.env.MAIL_USER && process.env.MAIL_USER !== 'your-email@gmail.com') {
      await transporter.sendMail(mailOptions);
    }
    
    return res.status(200).json({ 
      success: true, 
      message: 'پیام با موفقیت ارسال شد' 
    });
    
  } catch (error) {
    console.error('Contact form error:', error);
    
    return res.status(500).json({ 
      success: false, 
      message: 'خطایی در پردازش درخواست رخ داد' 
    });
  }
});

// Health check endpoint
app.get('/health', (req, res) => {
  return res.status(200).json({ status: 'UP' });
});

// Start the server
app.listen(PORT, () => {
  console.log(`API server running on port ${PORT}`);
});

module.exports = app; 