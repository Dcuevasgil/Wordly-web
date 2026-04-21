import { BrowserRouter, Routes, Route } from "react-router-dom";

import LoginPage from "./modules/auth/pages/LoginPage";

import Dashboard from "./modules/learn/pages/Dashboard";
import DashboardHome from "./modules/learn/pages/DashboardHome";
import Settings from "./modules/learn/pages/Settings";
import Messages from "./modules/learn/pages/Messages";
import Practice from "./modules/learn/pages/Practice";


import PrivateRoute from "./router/PrivateRoute";
import PublicRoute from "./router/PublicRoute";

import UserLevelModal from "./modules/onboarding/components/modals/UserLevelModal";

function App() {
  return (
    <BrowserRouter>
      <Routes>

        {/* 🔓 PUBLIC */}
        <Route element={ <PublicRoute /> }>
          <Route path="/" element={<LoginPage />} />
        </Route>
              

        <Route path="/onboarding" element={<UserLevelModal />} />

       {/* 🔐 PRIVATE */}
        <Route element={<PrivateRoute />}>

          <Route path="/dashboard" element={<Dashboard />}>

            <Route index element={<DashboardHome />} />
            <Route path="settings" element={<Settings />} />
            <Route path="messages" element={<Messages />} />
            <Route path="practice" element={<Practice />} />

          </Route>

        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;