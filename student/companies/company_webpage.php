<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Company Details</title>
    <style>
      /* CSS code for the header */
      header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #0077b6;
        color: white;
        padding: 10px;
      }

      /* CSS code for the main content */
      main {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 20px;
      }

      label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
      }

      input {
        padding: 5px;
        margin-bottom: 20px;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 3px;
      }

      /* CSS code for the buttons */
      button {
        background-color: #0077b6;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
      }

      button:hover {
        background-color: #004b87;
      }

      /* CSS code for the footer */
      footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px;
        position: fixed;
        bottom: 0;
        width: 100%;
      }
    </style>
  </head>
  <body>
    <!-- header section -->
    <header>
      <img src="company_logo.png" alt="Company Logo" width="50" height="50">
      <span>Company Name</span>
      <div>
        <button>Submit Proposal</button>
        <button>Update Details</button>
        <button>Logout</button>
      </div>
    </header>

   
    <footer>
      &copy; 2023 Company Name. All rights reserved.
    </footer>
  </body>
</html>
