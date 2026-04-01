import { BrowserRouter, Routes, Route } from "react-router-dom";

import LoginPage from "./modules/auth/pages/LoginPage";
import Dashboard from "./modules/learn/pages/Dashboard";
import PrivateRoute from "./router/PrivateRoute";
import PublicRoute from "./router/PublicRoute";
import UserLevelModal from "./modules/onboarding/components/modals/UserLevelModal";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route 
          path="/" 
          element={
            <PublicRoute>
              <LoginPage />
            </PublicRoute>
          } 
        />

        <Route path="/onboarding" element={<UserLevelModal />} />
                
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