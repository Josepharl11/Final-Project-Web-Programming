import pytest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os
from datetime import datetime
from config import *

class TestLogin:
    def setup_method(self):
        self.driver = webdriver.Chrome()
        self.driver.implicitly_wait(10)

    def teardown_method(self):
        if self.driver:
            self.driver.quit()

    def take_screenshot(self, name):
        timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
        if not os.path.exists(SCREENSHOTS_PATH):
            os.makedirs(SCREENSHOTS_PATH)
        self.driver.save_screenshot(f"{SCREENSHOTS_PATH}/{name}_{timestamp}.png")

    def test_login_successful(self):
        """
        HU-1: Login exitoso (Camino feliz)
        """
        self.driver.get(f"{BASE_URL}/login.php")
        
        self.driver.find_element(By.NAME, "usuario").send_keys(TEST_USER)
        self.driver.find_element(By.NAME, "password").send_keys(TEST_PASSWORD)
        
        self.take_screenshot("login_before_submit")
        
        self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        
        assert "index.php" in self.driver.current_url
        self.take_screenshot("login_success")

    def test_login_invalid_credentials(self):
        """
        HU-2: Login fallido (Prueba negativa)
        """
        self.driver.get(f"{BASE_URL}/login.php")
        
        self.driver.find_element(By.NAME, "usuario").send_keys("wrong")
        self.driver.find_element(By.NAME, "password").send_keys("wrong")
        
        self.take_screenshot("login_invalid_before")
        
        self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        
        error = self.driver.find_element(By.CLASS_NAME, "error-message")
        assert "incorrectos" in error.text
        self.take_screenshot("login_invalid_error")