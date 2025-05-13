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
      const msg = 'سیاست CORS اجازه دسترسی از این منبع را نمی‌دهد.';
      return callback(new Error(msg), false);
    }
    return callback(null, true);
  },
  credentials: true
}));
app.use(bodyParser.json());

// Error handling middleware for JSON parsing errors
app.use((err, req, res, next) => {
  if (err instanceof SyntaxError && err.status === 400 && 'body' in err) {
    console.error('JSON parsing error:', err);
    return res.status(400).json({ 
      success: false, 
      message: 'خطا در پردازش اطلاعات ارسالی. لطفاً فرمت JSON را بررسی کنید.' 
    });
  }
  next();
});

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
    
    // Validate input with detailed error messages
    const errors = {};
    let hasErrors = false;
    
    if (!name || !name.trim()) {
      errors.name = ['لطفاً نام خود را وارد کنید'];
      hasErrors = true;
    }
    
    if (!email || !email.trim()) {
      errors.email = ['لطفاً ایمیل خود را وارد کنید'];
      hasErrors = true;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      errors.email = ['لطفاً یک ایمیل معتبر وارد کنید'];
      hasErrors = true;
    }
    
    if (!subject || !subject.trim()) {
      errors.subject = ['لطفاً موضوع پیام را وارد کنید'];
      hasErrors = true;
    }
    
    if (!message || !message.trim()) {
      errors.message = ['لطفاً پیام خود را وارد کنید'];
      hasErrors = true;
    }
    
    if (hasErrors) {
      return res.status(422).json({ 
        success: false, 
        message: 'لطفاً تمام فیلدها را به درستی پر کنید',
        errors
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
  try {
    // Add any health checks here (database, services, etc.)
    return res.status(200).json({ 
      success: true, 
      message: 'سیستم فعال است',
      status: 'UP' 
    });
  } catch (error) {
    console.error('Health check error:', error);
    return res.status(500).json({ 
      success: false, 
      message: 'خطایی در بررسی وضعیت سیستم رخ داد',
      status: 'DOWN'
    });
  }
});

// Start the server
app.listen(PORT, () => {
  console.log(`API server running on port ${PORT}`);
});

module.exports = app; 