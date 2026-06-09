<section class="stats-grid">
    <div class="stat-card glass">
      <div class="stat-info">
        <h3>$24,500</h3>
        <p>Total Revenue</p>
        <div class="stat-trend trend-up">
          <i class="ri-arrow-up-line"></i>
          <span>+12.5%</span>
        </div>
      </div>
      <div class="stat-icon bg-purple">
        <i class="ri-money-dollar-circle-line"></i>
      </div>
    </div>

    <div class="stat-card glass">
      <div class="stat-info">
        <h3>1,250</h3>
        <p>Total Sales</p>
        <div class="stat-trend trend-up">
          <i class="ri-arrow-up-line"></i>
          <span>+5.2%</span>
        </div>
      </div>
      <div class="stat-icon bg-pink">
        <i class="ri-shopping-cart-2-line"></i>
      </div>
    </div>

    <div class="stat-card glass">
      <div class="stat-info">
        <h3>352</h3>
        <p>New Customers</p>
        <div class="stat-trend trend-down">
          <i class="ri-arrow-down-line"></i>
          <span>-2.1%</span>
        </div>
      </div>
      <div class="stat-icon bg-teal">
        <i class="ri-user-add-line"></i>
      </div>
    </div>

    <div class="stat-card glass">
      <div class="stat-info">
        <h3>8,400</h3>
        <p>Total Visits</p>
        <div class="stat-trend trend-up">
          <i class="ri-arrow-up-line"></i>
          <span>+8.4%</span>
        </div>
      </div>
      <div class="stat-icon bg-orange">
        <i class="ri-bar-chart-groupped-line"></i>
      </div>
    </div>
  </section>

        <!-- Charts & Activity -->
        <section class="charts-grid">
          <!-- Main Chart -->
            <div class="chart-card glass">
            <div class="chart-header">
              <h3>Revenue Overview</h3>
              <div class="chart-actions">
                <select class="glass-select">
                  <option>Weekly</option>
                  <option>Monthly</option>
                  <option>Yearly</option>
                </select>
                <i class="ri-arrow-down-s-line" style="position: absolute; right: 1rem; pointer-events: none; color: var(--text-muted);"></i>
              </div>
            </div>
            <div class="chart-canvas-container">
                <canvas id="revenueChart"></canvas>
            </div>
          </div>

          <!-- Recent Activity -->
          <div class="chart-card glass">
            <div class="chart-header">
              <h3>Recent Activity</h3>
            </div>
            <ul class="activity-list">
              <li class="activity-item">
                <div class="activity-icon bg-purple">
                  <i class="ri-file-text-line"></i>
                </div>
                <div class="activity-info">
                  <h5>New Invoice Generated</h5>
                  <span>Just now</span>
                </div>
              </li>
              <li class="activity-item">
                <div class="activity-icon bg-pink">
                  <i class="ri-user-smile-line"></i>
                </div>
                <div class="activity-info">
                  <h5>New User Registered</h5>
                  <span>2 hours ago</span>
                </div>
              </li>
              <li class="activity-item">
                <div class="activity-icon bg-teal">
                  <i class="ri-shopping-bag-line"></i>
                </div>
                <div class="activity-info">
                  <h5>Product Shipped</h5>
                  <span>5 hours ago</span>
                </div>
              </li>
              <li class="activity-item">
                <div class="activity-icon bg-orange">
                  <i class="ri-star-line"></i>
                </div>
                <div class="activity-info">
                  <h5>New Review Received</h5>
                  <span>1 day ago</span>
                </div>
              </li>
            </ul>
          </div>
        </section>

        <!-- Data Tables -->
  <h2 style="margin-bottom: 2rem;">Data Tables</h2>

            <div class="glass" style="padding: 2rem; border-radius: 16px;">
                <h3 style="margin-bottom: 1.5rem; color: var(--primary);">Employee Directory</h3>
                <div class="table-overlay">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Status</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td><span class="status-badge status-success">Active</span></td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011/07/25</td>
                                <td><span class="status-badge status-warning">Pending</span></td>
                                <td>$170,750</td>
                            </tr>
                            <!-- More dummy data -->
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>2009/01/12</td>
                                <td><span class="status-badge status-success">Active</span></td>
                                <td>$86,000</td>
                            </tr>
                            <tr>
                                <td>Cedric Kelly</td>
                                <td>Senior Javascript Developer</td>
                                <td>Edinburgh</td>
                                <td>22</td>
                                <td>2012/03/29</td>
                                <td><span class="status-badge status-success">Active</span></td>
                                <td>$433,060</td>
                            </tr>
                            <tr>
                                <td>Airi Satou</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>33</td>
                                <td>2008/11/28</td>
                                <td><span class="status-badge status-danger">Inactive</span></td>
                                <td>$162,700</td>
                            </tr>
                             <tr>
                                <td>Brielle Williamson</td>
                                <td>Integration Specialist</td>
                                <td>New York</td>
                                <td>61</td>
                                <td>2012/12/02</td>
                                <td><span class="status-badge status-success">Active</span></td>
                                <td>$372,000</td>
                            </tr>
                             <tr>
                                <td>Herrod Chandler</td>
                                <td>Sales Assistant</td>
                                <td>San Francisco</td>
                                <td>59</td>
                                <td>2012/08/06</td>
                                <td><span class="status-badge status-success">Active</span></td>
                                <td>$137,500</td>
                            </tr>
                             <tr>
                                <td>Rhona Davidson</td>
                                <td>Integration Specialist</td>
                                <td>Tokyo</td>
                                <td>55</td>
                                <td>2010/10/14</td>
                                <td><span class="status-badge status-success">Active</span></td>
                                <td>$327,900</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            !-- Basic Inputs -->
    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <h3 class="form-section-title">Basic Inputs</h3>
        <form>
            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Text Input</label>
                <input type="text" placeholder="John Doe" class="glass-select" style="width:100%;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Email Address</label>
                <div style="position:relative;">
                    <i class="ri-mail-line" style="position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--text-muted);"></i>
                    <input type="email" placeholder="example@email.com" class="glass-select" style="width:100%; padding-left: 2.8rem;">
                </div>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Password</label>
                <input type="password" value="password123" class="glass-select" style="width:100%;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Helper Text</label>
                <input type="text" class="glass-select" style="width:100%;">
                <span style="display:block; font-size:0.8rem; color:var(--text-muted); margin-top:0.3rem;">We'll never share your email with anyone else.</span>
            </div>
        </form>
    </div>

    <!-- Selection & Toggles -->
    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <h3 class="form-section-title">Selection Controls</h3>
        
        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Select Dropdown</label>
            <div style="position:relative;">
                <select class="glass-select" style="width:100%;">
                    <option>Option 1</option>
                    <option>Option 2</option>
                    <option>Option 3</option>
                </select>
                <i class="ri-arrow-down-s-line" style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); pointer-events:none; color:var(--text-muted);"></i>
            </div>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.8rem; color:var(--text-muted); font-size:0.9rem;">Checkboxes</label>
            <label class="checkbox-container">
                <input type="checkbox" class="checkbox-input" checked>
                <span>Checked Option</span>
            </label>
            <label class="checkbox-container">
                <input type="checkbox" class="checkbox-input">
                <span>Unchecked Option</span>
            </label>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display:block; margin-bottom:0.8rem; color:var(--text-muted); font-size:0.9rem;">Radio Buttons</label>
            <label class="radio-container">
                <input type="radio" name="radio-group" class="radio-input" checked>
                <span>Radio Option 1</span>
            </label>
            <label class="radio-container">
                <input type="radio" name="radio-group" class="radio-input">
                <span>Radio Option 2</span>
            </label>
        </div>

        <div>
            <label style="display:block; margin-bottom:0.8rem; color:var(--text-muted); font-size:0.9rem;">Toggles</label>
            <div style="display:flex; align-items:center; gap:1rem;">
                <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
                <span>Notifications</span>
            </div>
        </div>
    </div>

    <!-- Advanced & Buttons -->
    <div class="glass" style="padding: 2rem; border-radius: 16px;">
        <h3 class="form-section-title">Advanced & Buttons</h3>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">Text Area</label>
            <textarea class="glass-select" rows="4" style="width:100%; height:auto;" placeholder="Write a message..."></textarea>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display:block; margin-bottom:0.5rem; color:var(--text-muted); font-size:0.9rem;">File Upload</label>
            <div style="border: 2px dashed var(--border-glass); padding: 2rem; text-align: center; border-radius: 12px; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='transparent'">
                <i class="ri-upload-cloud-2-line" style="font-size: 2rem; color: var(--primary);"></i>
                <p style="font-size: 0.9rem; margin-top: 0.5rem; color: var(--text-muted);">Click to upload or drag and drop</p>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
            <button class="glass-select" style="background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; font-weight: 500;">Primary Action</button>
            <button class="glass-select" style="background: transparent; color: var(--text-main); border: 1px solid var(--text-muted); padding: 0.8rem 1.5rem; font-weight: 500;">Secondary</button>
            <button class="glass-select" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 0.8rem 1.5rem; font-weight: 500;">Danger</button>
        </div>
    </div>