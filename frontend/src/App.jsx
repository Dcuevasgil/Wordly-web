import { BrowserRouter, Routes, Route } from "react-router-dom";

import LoginPage from "./modules/auth/pages/LoginPage";
import Dashboard from "./modules/learn/pages/Dashboard";
import PrivateRoute from "./router/PrivateRoute";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        
        <Route path="/" element={<LoginPage />} />
        
        <Route 
            path="/dashboard" 
            element={
                <PrivateRoute>
                    <Dashboard />
                </PrivateRoute>
            } 
        />


      </Routes>
    </BrowserRouter>
  );
}

export default App;